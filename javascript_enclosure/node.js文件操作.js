async copy(src, dst) {
  return new Promise((resolve) => {
    let stat = fs.stat;
    this.mkdirsSync(dst);
    // 读取目录中的所有文件/目录
    const that = this;
    fs.readdir(src, async function (err, paths) {
      if (err) {
        throw err;
      }
      await Promise.all(paths.map((path) => {


        var _src = src + '/' + path,
          _dst = dst + '/' + path,
          readable, writable;
        return new Promise((resolve) => {
          stat(_src, function (err, st) {
            if (err) {
              throw err;
            }
            // 判断是否为文件
            if (st.isFile()) {
              // 创建读取流
              readable = fs.createReadStream(_src);
              // 创建写入流
              writable = fs.createWriteStream(_dst);
              // 通过管道来传输流
              readable.pipe(writable);
              resolve(true);
            }
            // 如果是目录则递归调用自身
            else if (st.isDirectory()) {
              fs.exists(_dst, function (exists) {
                // 已存在
                if (exists) {
                  resolve(that.copy(_src, _dst));;
                }
                // 不存在
                else {
                  fs.mkdir(_dst, function () {
                    resolve(that.copy(_src, _dst));
                  });
                }
              });
            }
          });
        })


      })).then(() => {
        resolve(true)
      });
    });
  })

};


async delDir(path: string) {

  let files: any[] = [];
  if (fs.existsSync(path)) {
    files = fs.readdirSync(path);
    files.map((file) => {
      let curPath = path + "/" + file;
      if (fs.statSync(curPath).isDirectory()) {
        this.delDir(curPath); //递归删除文件夹
      } else {
        fs.unlinkSync(curPath); //删除文件
      }
    })
    fs.rmdirSync(path);
  }

}