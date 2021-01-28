<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta HTTP-EQUIV="pragma" content="no-cache">
    <meta HTTP-EQUIV="Cache-Control" content="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" content="0">
    <title>处理订单</title>
    <link rel="stylesheet" href="/css/yw_global.css"/>
    <link rel="stylesheet" href="/css/yw_swiper.min.css"/>
    <link rel="stylesheet" href="/css/yw_main.css"/>
    <link rel="stylesheet" href="/crm/css/layer.css"/>
    <link rel="stylesheet" href="/crm/css/juhua.css"/>
    <script src="/js/jquery.min.js"></script>
    <script src="/crm/js/vue.js"></script>
    <script src="/crm/js/util.js"></script>
    <script src="/crm/js/layer.js"></script>
    <script src="/crm/js/juhua.js"></script>
    <script src="/crm/js/PickerCtrls.js"></script>
    <script src="/crm/js/DayPicker.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.6.0.js" type="text/javascript" charset="utf-8"></script>
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/vant@2.10/lib/index.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/vant@2.10/lib/vant.min.js"></script>

    <script>
        /**
         * rem适配 iPhone6下html字号为100px， 375px下1rem=100px
         */
        (function (doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {

                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    docEl.style.fontSize = 100 * (clientWidth / 375) + 'px';
                    // console.log("root fontsize:"+ 100 * (clientWidth / 375));
                    /*  var  tipDiv = document.getElementById("tipDiv");
                      if (tipDiv)
                         {
                           tipDiv.innerHTML= "root fontsize:"+ 100 * (clientWidth / 375);
                         } */
                };

            // Abort if browser does not support addEventListener
            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
        wx.config(<?php echo $js->config(array('chooseImage', 'getLocalImgData', 'previewImage', 'uploadImage'), false, true); ?>);

    </script>
    @include('crmyy.layouts.common_css')

    <style>
        .choose {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #9b9b9b;
        }

        .choose .van-dropdown-menu__bar {
            background-color: #f1f1f1;
            box-shadow: none;
            height: 0.38rem;
        }

        .choose .van-dropdown-menu__title {
            padding-left: 0;
        }

        .choose .van-dropdown-menu__title::after {
            display: none;
        }

        .van-field {
            padding-left: 0;
            background-color: #f1f1f1;
            border-bottom: 1px solid #9b9b9b;
        }

        .van-field__label {
            display: none;
        }

        .van-field__control {
            color: #9b9b9b;
        }

        .choose .delete {
            height: 0.24rem;
            width: auto;
            padding: 0 .1rem;
            border-radius: 0.12rem;
            font-size: 0.1rem;
            line-height: 0.24rem;
            background-color: #F0E716;
        }

        .detail .title {
            margin: .15rem 0;
            font-size: .18rem;
            font-weight: 600;
            color: #000000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .add {
            width: 0.24rem;
            height: 0.24rem;
            text-align: center;
            font-size: 0.18rem;
            line-height: 0.24rem;
            background-color: #F0E716;
            border-radius: 50%;
        }
        html,body {
            height: auto !important;
        }
    </style>

</head>
<body style="background-color: #FFFFFF">

<div id="kParent">

    @include('crmyy.layouts.tab_header')


    <div class="detail">
        <div class="title">预约时间</div>
        <div class="yydate" id="kItemTime">
            <span>预约</span>
            <span id="kCustomYYTime" style="color:#000000;font-weight:800;"></span>
            <span>上门</span>
        </div>
    </div>

    @include('crmyy.layouts.CustomerDetail')

    <div class="detail">
        <div class="title">开工日期</div>
    </div>

    <div id="kItemYY" style="margin-left:5vw;width:90vw;
        background-color: #f1f1f1; border-radius:0.22rem;height:0.44rem;">

        <div id="kYYTime"
             style="float:left;width:calc(100% - 0.15rem - 0.6rem);color: #9B9B9B;height:0.44rem;line-height:0.44rem;
                margin-left:0.31rem;min-width:0.28rem;font-size:0.14rem;font-weight:normal;background-color: rgba(0,200,0,0)">
            <div id="kDatePicker" onclick="clickedMyDayPicker()" style="float:left;min-width: 100px;">0000-00-00
            </div>
            <div id="kHourPicker" onclick="clickedHourPicker(this)"
                 style="float:left;margin-left:0px;min-width: 60px;">
                <span id="kHourPickerValue">00</span>&nbsp;时
            </div>
            <div id="kMiniPicker" onclick="clickedMiniPicker(this)"
                 style="float:left;margin-left:0px;min-width: 60px;">
                <span id="kMiniPickerValue">00</span>&nbsp;分
            </div>

        </div>
        <img src="/crm/images/order/yuyue_icon_riqi@3x.png" onclick="clickedMyDayPicker()"
             style="float:left;display:block;margin-top:0.15rem;width:0.16rem;height:0.14rem;"/>
    </div>
    <div id='scene_vue'>

    </div>
    <div class="detail">
        <div class="title">现场信息</div>
    </div>

    <div id="spaceIDDDD"
         style="margin-top:1px;height: 50px;width: 100%;background-color:rgba(255,255,255,0);overflow: hidden;"></div>

    <button id="kNextButton" onclick="clickedNext()" style="display:block;position:relative;z-index:100;bottom:0.22rem;
    left: 50%;transform: translate(-50%); width:3.35rem;border-radius: 0.22rem; height:0.44rem;text-align:center;border:none;
 font-size:0.14rem;font-weight:normal;color:#000000;background-color:#F0E716;line-height:47px;">@{{ nextBtnTitle }}
    </button>

</div>
</body>

<script>

    var orderId = '<?php echo $orderid; ?>';
    var storeName = '<?php echo $store; ?>';
    //按对象方式直接接收（json里面又有json的情况，如果按字符串来接收内层的json会自动加了双引号导致解析问题）
    var orderObj = <?php echo $order; ?>;

    console.log("orderObj.status:" + orderObj.status);
    console.log("orderObj:" + JSON.stringify(orderObj));


    var tabSm = $("#" + "tabSm")[0];
    tabSm.removeAttribute("onclick");
    tabSm.className = 'active';

    //隐藏下单时间
    var downTimeRow = $("#" + "downTimeRow")[0];
    downTimeRow.style.display = 'none';

    var scene_dec = "";
    if (orderObj && orderObj.order_detail) {
        var detail = JSON.parse(orderObj.order_detail);
        if (Object.keys(detail).length > 0 && detail.scene_dec) {
            var sceneEL = $("#" + "scene_decs")[0];
            sceneEL.innerHTML = detail.scene_dec;
        } else {
        }
    }

    // var selCtId = curCtId;

    // console.log("curCtId:"+curCtId +",curCtName:"+curCtName);


    // console.log("crmAllTC:"+JSON.stringify(crmAllTC))

    var vm = new Vue({
        el: '#kParent',
        data: {
            orderObj: {},
            upfileNames: ''  //fileName1,fileName2,...

        },
        computed: {
            // 仅读取
            nextBtnTitle: function () {
                if (orderObj.status >= 4) {
                    return '查看定购方案';
                } else {
                    return '制定方案'
                }
            }
        },
        created: function () {
            console.log("===created：");
        },
        mounted: function () {
            console.log("===mounted：");

            this.orderObj = orderObj;
            this.upfileNames = orderObj.xcImages ? orderObj.xcImages : "";
            // loadImages(this.upfileNames);
            setTimeout("loadItems()", 100);

        },

        methods: {}

    });


    function clickedNext() {
        console.log("clickedNext")
        // var date = new Date();
        //var create_time = date2str(date,"yyyy-MM-dd hh:mm:ss");

        let wk_date = getYYTime();
        if (wk_date.length != 16 || wk_date == '0000-00-00 00:00') {
            alert('请确定施工时间');
            return;
        }
        let scene_detail;
        scene_detail = sv.componentList

        let ctDetail = {
            scene_detail
        };

        var noupstatus = 0;

        if (orderObj.status >= 4) {
            noupstatus = 1;
        }
        if (noupstatus) {
            //重定向到指定订单页
            window.location.replace("/crm/yy/go2orderlist/" + orderId);
            return;
        }

        showJuhua(true);
        var dataDic = {
            "orderId": orderId,
            "work_date": wk_date,
            "ctDetail": JSON.stringify(ctDetail),
            "noupstatus": noupstatus
        };
        console.log("dataDic:" + JSON.stringify(dataDic));
        $.ajax({
            type: 'POST',
            url: "{{url('/crm/yy/updateOrder/3')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "order": dataDic,
            },

            success: function (data) {
                showJuhua(false);
                console.log("data:" + data);
                console.log("typeof data:" + typeof data);
                if (data) {
                    var obj = JSON.parse(data);

                    if (obj.code == 0) {
                        //console.log ("typeof obj:"+typeof obj);

                        if (obj.data) {
                            var order = obj.data;
                            vm.orderObj.status = order.status;
                            //console.log("obj:"+JSON.stringify(obj.data));
                            //loadItems(order.status);
                        }

                        tipMsg("已提交量房信息，即将跳转到商城选购方案！");

                        setTimeout(function () {
                            window.location.replace("/weixin/catalog/home");
                        }, 1000);

                    } else {
                        tipMsg("提交信息失败！");
                    }

                } else {
                    tipMsg("提交失败！");
                }
            },
            error: function (rsp) {
                showJuhua(false);
                console.log("err:" + JSON.stringify(rsp));
                tipMsg("系统异常！");
            }
        });

    }

    function f_close() {
        if (typeof (WeixinJSBridge) != "undefined") {
            WeixinJSBridge.call('closeWindow');
        } else {
            if (navigator.userAgent.indexOf("MSIE") > 0) {
                if (navigator.userAgent.indexOf("MSIE 6.0") > 0) {
                    window.opener = null;
                    window.close();
                } else {
                    window.open('', '_top');
                    window.top.close();
                }
            } else if (navigator.userAgent.indexOf("Firefox") > 0) {
                window.location.href = 'about:blank ';
            } else {
                window.opener = null;
                window.open('', '_self', '');
                window.close();
            }
        }
    }

    function clickedCall(el) {
        var phoneEL = $("#" + "kCustomPhone")[0];
        //tipMsg(phoneEL.innerHTML);
        window.location.href = 'tel://' + phoneEL.innerHTML;
    }

    function clickedItem(index) {
        console.log("index:" + index);
    }


    function loadOrderInfo()//只允许初始化只读信息/或者已经写进数据库的信息
    {
        if (orderObj) {
            refreshTabIcons(orderObj.status, 1);


            var yytimeEL = $("#" + "kCustomYYTime")[0];
            var timeStr = '';
            if (orderObj.yytime && orderObj.yytime.length > 4) {
                var cur_time = str2OtherDateFormat(orderObj.yytime, "yyyy-MM-dd hh:mm");
                timeStr += cur_time;
            } else {
                timeStr += "待确定";
            }
            yytimeEL.innerHTML = timeStr;


            var time = $("#" + "kdownTime")[0];
            time.innerHTML = orderObj.created_at;

            var nameEL = $("#" + "kCustomName")[0];
            nameEL.innerHTML = orderObj.user_name;
            var phoneEL = $("#" + "kCustomPhone")[0];
            phoneEL.innerHTML = orderObj.phone;


            var addressEL = $("#" + "kCustomAddress")[0];

            var crmAddress = null;
            var addressStr = "";
            if (orderObj.address) {
                crmAddress = JSON.parse(orderObj.address);
            }

            if (crmAddress) {
                if (crmAddress.provinceName) {
                    addressStr += crmAddress.provinceName;
                }
                if (crmAddress.cityName) {
                    addressStr += crmAddress.cityName;
                }
                if (crmAddress.countryName) {
                    addressStr += crmAddress.countryName;
                }
                if (crmAddress.detailInfo) {
                    addressStr += crmAddress.detailInfo;

                }
            }

            addressEL.innerHTML = addressStr;

        }

    }


    function loadItems() {

        //  加载施工时间
        if (orderObj.work_date && orderObj.work_date.length > 4) {
            setYYTime(orderObj.work_date);
            var kDatePicker = $("#" + "kDatePicker")[0];
            kDatePicker.removeAttribute("onclick");
            var kHourPicker = $("#" + "kHourPicker")[0];
            kHourPicker.removeAttribute("onclick");
            var kMiniPicker = $("#" + "kMiniPicker")[0];
            kMiniPicker.removeAttribute("onclick");
        } else {
            var date = new Date();
            var cur_time = date2str(date, "yyyy-MM-dd hh:mm");
            //setYYTime(cur_time);
        }

        loadOrderInfo();
        // loadCTItems();

    }

    //====================图片上传相关start============


    //====================图片上传相关end============

    // =============================时间控件start===========
    function clickedSelPicker(el, scrollId, selList) {
        console.log("selList:" + JSON.stringify(selList));

        var divId = "picker" + el.id;

        var floatDeptPicker = document.getElementById(divId);
        var selectItemDic = {};

        if (selList) {
            for (var i = 0; i < selList.length; i++) {
                selectItemDic[(i)] = selList[i];
            }

            seletBoxPicker(el, scrollId, divId, selectItemDic, "callbackSelPicker", true, false, '', 60);
        }


        //layoutType:0-default(left-right;up-down),1-(right-left;up-down)
        //function seletBoxPicker(el,scrollId,divId,selectDic,"callbackSelPicker",backStyleIsClose,isColorPicker,otherScrollId,minWidth,layoutType)

    }

    function callbackSelPicker(divId, item) {
        console.log("callbackSelPicker:" + JSON.stringify(item));

        if (divId && divId.divId) {
            var index = divId.divId.indexOf("picker");

            var itemId = divId.divId.substring(index + "picker".length, divId.divId.length);

            console.log("divId:" + itemId + "Value");

            var itemEL = $("#" + itemId + "Value")[0];

            if (itemEL) {
                itemEL.innerHTML = item.value;
            }

        }

        closeCurFrame();
    }


    function clickedMyDayPicker() {

        if (orderObj.status > 2) {
            return;
        }

        var cur_time = window.yyDate;
        if (!cur_time) {
            var date = new Date();
            cur_time = date2str(date, "yyyy-MM-dd");
        }
        clickedDayPicker('', dayPickerCallback, cur_time, orderId);
    }

    function dayPickerCallback(dateValue) {
        console.log("dayPickerCallback:" + dateValue);
        var dateItem = $("#" + "kDatePicker")[0];
        ////format('yyyy-MM-dd hh:mm:ss')
        // var dateV = str2OtherDateFormat(dateValue,"yyyy.M.d");
        dateItem.innerHTML = dateValue;

        window.yyDate = dateValue;

    }

    function clickedHourPicker(el) {
        if (orderObj.status > 2) {
            return;
        }

        var list = [];

        for (var i = 0; i < 24; i++) {
            if (i < 10) {
                list.push("0" + i);
            } else {
                list.push("" + i);
            }
        }

        clickedSelPicker(el, 'kParent', list);

    }

    function clickedMiniPicker(el) {
        if (orderObj.status > 2) {
            return;
        }

        var list = [];

        for (var i = 0; i < 60; i++) {
            if (i < 10) {
                list.push("0" + i);
            } else {
                list.push("" + i);
            }
        }

        clickedSelPicker(el, 'kParent', list);
    }

    function setYYTime(yyTime) {
        window.yyDate = yyTime.substring(0, 10);
        var hh = yyTime.substring(11, 13);
        var mm = yyTime.substring(14, 16);
        // cur_time = date2str(date,"yyyy-MM-dd");
        var dateItem = $("#" + "kDatePicker")[0];
        if (dateItem) {
            dateItem.innerHTML = window.yyDate;
        }

        var itemHourEL = $("#" + "kHourPickerValue")[0];
        if (itemHourEL) {
            itemHourEL.innerHTML = hh;
        }

        var itemMiniEL = $("#" + "kMiniPickerValue")[0];
        if (itemMiniEL) {
            itemMiniEL.innerHTML = mm;
        }
    }


    function getYYTime() {
        var yyTime = "";
        var dateItem = $("#" + "kDatePicker")[0];
        if (dateItem && dateItem.innerHTML) {
            yyTime = dateItem.innerHTML;
        }

        var itemHourEL = $("#" + "kHourPickerValue")[0];
        if (itemHourEL && itemHourEL.innerHTML) {
            yyTime += " ";
            yyTime += itemHourEL.innerHTML;
        }

        var itemMiniEL = $("#" + "kMiniPickerValue")[0];
        if (itemMiniEL && itemMiniEL.innerHTML) {
            yyTime += ":" + itemMiniEL.innerHTML;
        }

        return yyTime;
    }


</script>
<script type="text/template" id="tpl">
    <div>
        <div class="detail">
            <div class="title">
                <div>现场信息</div>
                <div class="add" v-on:click="add_scene">+</div>
            </div>

        </div>

        <div class="img-upload" v-for="(com,com_index) in componentList" :key="com_index">
            <div class='choose'>
                <van-dropdown-menu>
                    <van-dropdown-item v-model="com.space_type" :options="option1" />
                </van-dropdown-menu>
                <div class="delete" v-on:click="del(com_index)">删除</div>
            </div>
            <van-cell-group>
                <van-field v-model="com.scene_area" label="" placeholder="输入面积m²"/>
            </van-cell-group>
            <van-field
                    v-model="com.scene_text"
                    rows="1"
                    autosize
                    label="留言"
                    type="textarea"
                    placeholder="输入描述"
            />

            <div :id="com_index+'kImagesDiv'" style="width: 100%;overflow: hidden;" class="clearfix">
            </div>

            <div :id="com_index+'kAddImageDiv'" v-on:click="imagePicker('kAddImageDiv','',com_index)"
                 style="position: relative;margin-top:20px;float: left;width: 25%">
                <img :id="com_index+'kIcon'" src="/crm/images/order/addimage@3x.png"
                     style="display:block;border: 1px dashed #979797; border-radius: 0.02rem;width: 90%;height: 0.65rem;text-align: center;"/>
                <img :id="com_index+'kRemoveIcon'" src="/crm/images/order/shangchuan_icon_shanchu@3x.png"
                     style="position:absolute;top: 0px; right: calc(10%); width: 0.2rem; display: block;border-radius: 50%;border: 1px solid #fff;"/>
            </div>

        </div>

    </div>
</script>

<script>
    var sv = new Vue({
        el: '#scene_vue',
        template: '#tpl',
        data: {
            option1: [
                { text: '选择空间类型', value: -1 },
                { text: '全部商品', value: 0 },
                { text: '新款商品', value: 1 },
                { text: '活动商品', value: 2 },
            ],
            componentList: [{
                space_type:0,
                scene_area: null,
                scene_text: "",
                upfileNames: '',
            }]
        },

        created:function(){
            var detail = JSON.parse(orderObj.order_detail);
            if (Object.keys(detail).length > 0 && detail.scene_detail) {
                this.componentList = detail.scene_detail;
            }
        },
        mounted:function(){
            console.log('mounted');
            //重载图片
            this.componentList.map((item,index)=>{
                this.loadImages(item.upfileNames,index);
            })

        },
        methods: {


            add_scene(res) {
                console.log("add_scene: ", res);
                this.componentList.push({
                    space_type:-1,
                    scene_area: null,
                    scene_text: "",
                    upfileNames: '',
                })
            },
            del(com_index) {
                this.componentList.splice(com_index, 1);
            },
            imagePicker(id, imgPath, index) {
                console.log("===imagePicker:" + id);

                if ('kAddImageDiv' == id) {
                    if (orderObj.status >= 3) {
                        //状态>=3 就不让上传了
                    } else {
                        this.upload_bill(index);
                    }
                }

            },
            upload_bill: function (index) {
                const that = this;
                wx.chooseImage({
                    count: 1,// 最多可以选择的图片张数
                    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                    success: function (res) {
                        var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                        var u = navigator.userAgent, app = navigator.appVersion;
                        if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {
                            var bill = "<div class='img_contain'><img class='bill_img' v-on:click='previewImage(\"" + localIds[0] + "\")' src='" + localIds[0] + "'/></div>";
                            $("#" + index + "imgs_contain").append(bill);
                            console.log('this.uploadImage(localIds[0], index);');
                            console.log('upload_bill index', index);
                            that.uploadImage(localIds[0], index);
                        } else {
                            console.log('this.getLocalImgData(localIds[0],index)');
                            that.getLocalImgData(localIds[0], index)
                        }
                    }
                });
            },
            previewImage: function (current) {
                console.log('previewImage');
                wx.previewImage({
                    current: current, // 当前显示图片的http链接
                    urls: [current] // 需要预览的图片http链接列表
                });
            },
            uploadImage: function (chooseImage, index) {
                const that = this;
                wx.uploadImage({
                    localId: chooseImage, // 需要上传的图片的本地ID，由chooseImage接口获得
                    isShowProgressTips: 1, // 默认为1，显示进度提示
                    success: function (res) {
                        var serverId = res.serverId; // 返回图片的服务器端ID
                        console.log(' this.noticeServerDownImage(serverId, index);');
                        that.noticeServerDownImage(serverId, index);
                    }
                });
            },
            getLocalImgData: function (localIds, index) {
                const that = this;
                wx.getLocalImgData({
                    localId: localIds, // 图片的localID
                    success: function (res) {
                        console.log('getLocalImgData', res);
                        var localData = res.localData; // localData是图片的base64数据，可以用img标签显示
                        var bill = "<div class='img_contain'><img class='bill_img' v-on:click='previewImage(\"" + localData + "\")' src='" + localData + "'/></div>";
                        $("#" + index + "imgs_contain").append(bill);
                        console.log('getLocalImgData', res);
                        that.uploadImage(localIds, index);
                    }
                });
            },
            noticeServerDownImage: function (serverId, index) {
                const that = this;
                $.ajax({
                    url: '/crm/yy/saveImage/' + orderId + ',' + serverId + ',' + '1',
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        if (res.status == '1') {
                            if (that.componentList[index].upfileNames == '') {
                                that.componentList[index].upfileNames = serverId + '.jpg'; //upfileNames: 上传了的图片的路径 A,B,C,...
                            } else {
                                that.componentList[index].upfileNames += ',' + serverId + '.jpg';
                            }
                            that.loadImages(that.componentList[index].upfileNames, index);
                        } else {
                            that.loadImages(that.componentList[index].upfileNames, index);
                        }

                    }
                });
            },
            loadImages(upfileNames, index) {
                console.log("loadItems:" + upfileNames);
                var list = [];
                if (upfileNames && upfileNames.length > 0) {
                    var fileNames = upfileNames.split(",");
                    for (var i = 0; i < fileNames.length; i++) {
                        var item = {"id": (i + 1), "icon": fileNames[i]};
                        list.push(item);
                    }
                }
                var item = {"id": 1000, "icon": ""};
                list.push(item);
                this.refreshImages(list, index);

                if (orderObj.status >= 3) {
                    var nextButtonEL = $("#" +index+ "kAddImageDiv")[0];
                    nextButtonEL.style.display = 'none';
                }
            },

            refreshImages(list, index) {
                console.log(' refreshImages(list, index)');
                console.log(index);
                var parentDiv = $("#" + index + "kImagesDiv")[0];
                if (parentDiv) {
                    clearAllSubDom(parentDiv);
                }
                console.log('a')
                var addImageDivEL = $("#" + index + "kAddImageDiv")[0];
                if (!list || list.length <= 1) {
                    addImageDivEL.style.display = "block";
                    var removeIconEL = $("#" + index + "kRemoveIcon")[0];
                    removeIconEL.style.display = "none";
                    return;
                }
                console.log('b')
                console.log(addImageDivEL);
                addImageDivEL.style.display = "none";
                var items = list;
                var x = 0;
                var y = 40;
                var iconHW = 84;
                for (var i = 0; i < items.length; i++) {
                    var item = items[i];
                    var addItem = addImageDivEL.cloneNode(true);//true表示深度复制；如果是false，则只复制一层
                    console.log('addItem');
                    console.log(addItem);
                    parentDiv.appendChild(addItem);
                    addItem.style.display = "block";
                    addItem.style.float = "left";
                    addItem.id = index + "kTCItem" + i;

                    let idDic = {};
                    idDic[`${index}kIcon`] = "1";
                    idDic[`${index}kRemoveIcon`] = "1";
                    var subDoms = {};
                    getSubDomsByIds(addItem, idDic, subDoms);
                    addItem.style.width = "25%";
                    var removeIconEL = subDoms[`${index}kRemoveIcon`];

                    if (item.id != 1000) {
                        var iconEL = subDoms[`${index}kIcon`];
                        iconEL.src = "/crmUpload/xc/" + item.icon;
                        iconEL.className = 'noBorder';
                        var fullPath = window.location.protocol + "//" + window.location.host + "/crmUpload/xc/" + item.icon;
                        if (orderObj.status >= 5) {
                            addItem.setAttribute("onclick", "sv.previewImage('" + fullPath + "')");
                            removeIconEL.style.display = "none";
                        } else {
                            addItem.removeAttribute("onclick");
                            removeIconEL.style.display = "block";
                            this.setEv(removeIconEL, addItem, fullPath, item.icon,index);
                        }
                    } else {
                        addItem.className = 'addImgBtn';
                        addItem.setAttribute("onclick", "sv.imagePicker('kAddImageDiv',''," + index + ")");
                        removeIconEL.style.display = "none";
                    }
                }
            },
            setEv(el, parent, fullPath, fileName,index) {
                console.log(' setEv(el, parent, fullPath, fileName,index)');
                const that = this;
                $(parent).click(function () {
                    that.previewImage(fullPath);
                });

                $(el).click(function (event) {
                    that.clickedRemoveImage(fileName,index);
                    return false;  //页面不会跳转，也不会打印出1，等于同时调用了event.stopPropagation()和event.preventDefault()
                });
            },
            clickedRemoveImage(fileName,index) {
                confirmMsg("确定要删除该图片吗？", function () {
                    window.setTimeout("doRemoveImage('" + fileName + "',"+index+")", 20);
                });
            },
            doRemoveImage(fileName,index) {
                const that = this;
                $.ajax({
                    url: '/crm/yy/removeImage/' + orderId + ',' + fileName + ',' + '1',
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        console.log("doRemoveImage res:" + JSON.stringify(res));
                        var obj = res;
                        if (obj.code == 0) {
                            that.deleteOneImageStrFromAll(fileName,index);
                            tipMsg("已删除");
                            that.loadImages(that.componentList[index].upfileNames,index);
                        } else {
                            tipMsg(obj.msg);
                        }
                    },
                    fail: function (res) {
                        tipMsg("系统异常");
                    }
                });

            },
            deleteOneImageStrFromAll(fileName,index) {
                if (this.componentList[index].upfileNames && this.componentList[index].upfileNames.length > 0) {
                    var fileNames = this.componentList[index].upfileNames.split(",");
                    var desfileNames = "";
                    for (var i = 0; i < fileNames.length; i++) {
                        if (fileNames[i] != fileName) {
                            if (desfileNames) {
                                desfileNames += ",";
                            }
                            desfileNames += fileNames[i];
                        }
                    }
                    this.componentList[index].upfileNames = desfileNames;
                }

            }


        }
    })
</script>
@include('crmyy.layouts.tab_header_js')

</html>
