前端请求token过期时刷新token处理解决模型
## 1. 需求分析 ##
前台向后台请求数据，经常用到token。  
token到了一定时期，后台会判定请求的token过期，需要重新请求。  
但出现以下情况怎么办呢？  
前台同时向后台发出n个带token的请求，但请求的token都是过期的，  
每个请求都要先重新向后台刷新token，再回来执行刚刚的请求。  
这就出现了一个问题：多**次进行了不必要的请求token**  

## 2. 问题解决思路 ##
实际买票模拟情景：一堆人同时去一个窗口买票  
每个请求 = 去窗口买票  
token过期 = 售票员不在了  
刷新token = 去叫售票员回岗位  
  

> 参考[https://cloud.tencent.com/developer/article/1467376?from=singlemessage](https://cloud.tencent.com/developer/article/1467376?from=singlemessage)  

思路分析：  
大家都在排队买票，发现售票员不在了，没必要每个人都过去叫售票人买票，吩咐一个人过去就好了。  
怎么才能知道有人去叫售票人了呢，可以通过写一张纸条的方式，上面写着“有人去叫售票员了”，这样就可以解决了。

## 3. Javascript下的两种实现模型 ##  
假设token请求需要1s,用setTimeout来模拟，前台请求模拟是传一个半径r过去，要求后台模拟计算它的面积并返回。  

    //统计数据
    var tokenCount = 0
    //模拟本地缓存的token
    var tokenStorage = ''
    var tokenLock = false
    var reqQueue = []	//排队记录队列
    //token请求模型
    const getToken = (callback)=>{
    	tokenCount++
    	setTimeout(()=>{
    		console.log(`累计token次数为${tokenCount}`)
    		tokenStorage = 'tokenA'
    		callback()
    	},1000)
    }
### 3.1 callback实现模型 ###
	function requestByCallback(r){
		console.log(`准备计算半径为${r.data}`)
		if(!tokenStorage){
			//如果token木有缓存
			if(!tokenLock){//如果没人去拿token
				//上锁
				tokenLock = true
				//请求
				getToken(()=>{
					//拿到了token
					//排队
					reqQueue.push(r)
					console.log(reqQueue)
					reqQueue.map(requestByCallback)
					reqQueue = []
					//解锁
					tokenLock = false
				})
			}else{
				//发现有人去拿token了
				reqQueue.push(r) //乖乖排队吧
			}
		}else{
			//有token了，就返回请求结果(假设这些请求都是求一个圆的面积)
			let S = 2*3.14*r.data*r.data
			r.callback(S)
		}
	}
### 3.2 Promise实现模型 ###
	function requestByPromise(r){
		return new Promise((resolve,reject)=>{
			console.log(`准备计算半径为${r}`)
			if(!tokenStorage){
				//如果token木有缓存
				console.log(`半径为 ${r} 的无法计算，等待token请求`)
				if(!tokenLock){//如果没人去拿token
					//上锁
					tokenLock = true
					//请求
					getToken(()=>{
						//拿到了token
						//排队
						let p = ()=>requestByPromise(r).then((res)=>{
							resolve(res)//把队列形态的promise 的resolve的res 在这里完成 两级resolve
						})
						reqQueue.push(p)

						console.log('队列形态打印',reqQueue)
						reqQueue.forEach((v)=>{
							v()
						})//IE8以下不支持foreach
						let all = Promise.all(reqQueue)
						all.then((res)=>{
							console.log("看下队列形态的执行效果",res)	//看下队列形态的执行效果
						})
						reqQueue = []
						//解锁
						tokenLock = false
					})
				}else{
					//发现有人去拿token了
					 //乖乖排队吧
					let p = ()=>requestByPromise(r).then((res)=>{
						resolve(res)//把队列形态的promise 的resolve的res 在这里完成 两级resolve
					})
					reqQueue.push(p)
				}
			}else{
				//有token了，就返回请求结果(假设这些请求都是求一个圆的面积)
				let S = 2*3.14*r*r
				resolve(S)
			}
		})
	}