<template>
  <div class="view_play">
    <img
      class="bg"
      :class="bgActive > 1 ? 'tra' : ''"
      :src="bgList[bgActive]"
      alt=""
    />

    <div @click="copy" class="copylink">复制连接</div>
    <div class="main">
      <div class="tops">
        <span>固定庄家</span>
        <div class="top_info">
          <i>{{ run_number }}/12局</i>
          <i>上限:1000</i>
        </div>
        <span></span>
      </div>

      <div class="play">
        <div class="z" v-if="isCountDown">
          <img src="../../assets/img/others/12.png" alt="" />
          <span v-if="time > 0">{{ time }}</span>
        </div>

        <div class="can" id="can">
          <canvas id="game" v-show="playflag || run_state >= 2"></canvas>
          <img
            v-show="playflag || run_state >= 2"
            class="gamea"
            src="../../assets/img/others/6.png"
            alt=""
          />
          <canvas id="zgame" v-show="!playflag && run_state === 1"></canvas>
          <img
            v-show="!playflag && run_state === 1"
            src="../../assets/img/others/23.png"
            class="gameb"
            alt=""
          />
        </div>
      </div>

      <!-- 左 -->
      <div class="zw_l_and_r zw_left is38">
        <span
          :class="item == 1 ? 'rz' : ''"
          v-for="(item, index) in codes.left"
          @click="joinRoomCode(item.code)"
          :style="getStyle(codes.left.length, index)"
          :key="index"
        >
          <!-- 入座逻辑 -->
          <div
            :class="
              members[item.uid] && members[item.uid].isOnline === false
                ? 'leave'
                : ''
            "
            v-if="members[item.uid] && members[item.uid].code > 0"
            class="user"
          >
            <div class="head-bg">
              <img src="../../assets/img/others/3touming.png" alt="" />
              <div class="head-user">
                <img :src="members[item.uid].avatar" alt="" />
              </div>
              <div
                v-if="
                  state === 0 &&
                  members[item.uid] &&
                  members[item.uid].ready === true
                "
                class="ready"
              >
                准备
              </div>
              <div v-else>
                <span class="ready" style="color: #fff" v-if="state >= 1">{{
                  members[item.uid].integral
                }}</span>
              </div>
            </div>
          </div>

          <img
            v-else
            class="default-img"
            src="../../assets/img/others/3.png"
            alt=""
          />

          <!-- <div v-if="item == 1">
                    <img src="" alt="" />
                    <i>0分</i>
                </div> -->
        </span>
      </div>
      <!-- 右 -->
      <div class="zw_l_and_r is38 zw_right">
        <span
          v-for="(item, index) in codes.right"
          :style="getStyle(codes.left.length, index)"
          @click="joinRoomCode(item.code)"
          :key="index"
        >
          <div
            :class="
              members[item.uid] && members[item.uid].isOnline === false
                ? 'leave'
                : ''
            "
            v-if="members[item.uid] && members[item.uid].code > 0"
            class="user"
          >
            <div class="head-bg">
              <img src="../../assets/img/others/3touming.png" alt="" />
              <div class="head-user">
                <img :src="members[item.uid].avatar" alt="" />
              </div>
              <div
                v-if="
                  state === 0 &&
                  members[item.uid] &&
                  members[item.uid].ready === true
                "
                class="ready"
              >
                准备
              </div>
              <div v-else>
                <span class="ready" style="color: #fff" v-if="state >= 1">{{
                  members[item.uid].integral
                }}</span>
              </div>
            </div>
          </div>

          <img
            v-else
            class="default-img"
            src="../../assets/img/others/3.png"
            alt=""
          />
        </span>
      </div>
      <div class="zw_top zw_top_top">
        <span
          v-for="(item, index) in codes.top"
          @click="joinRoomCode(item.code)"
          :class="index >= codes.top.length / 2 ? 'zw_float_right' : ''"
          :key="index"
        >
          <div
            :class="
              members[item.uid] && members[item.uid].isOnline === false
                ? 'leave'
                : ''
            "
            v-if="members[item.uid] && members[item.uid].code > 0"
            class="user"
          >
            <div class="head-bg">
              <img src="../../assets/img/others/3touming.png" alt="" />
              <div class="head-user">
                <img :src="members[item.uid].avatar" alt="" />
              </div>
              <div
                v-if="
                  state === 0 &&
                  members[item.uid] &&
                  members[item.uid].ready === true
                "
                class="ready"
              >
                准备
              </div>
              <div v-else>
                <span class="ready" style="color: #fff" v-if="state >= 1">{{
                  members[item.uid].integral
                }}</span>
              </div>
            </div>
          </div>

          <img
            v-else
            class="default-img"
            src="../../assets/img/others/3.png"
            alt=""
          />
        </span>
      </div>

      <!-- is60 60局添加该class-->
      <div class="zw_top zw_bottom">
        <span
          v-for="(item, index) in codes.bottom"
          @click="joinRoomCode(item.code)"
          :class="index >= codes.bottom.length / 2 ? 'zw_float_right' : ''"
          :key="index"
        >
          <div
            :class="
              members[item.uid] && members[item.uid].isOnline === false
                ? 'leave'
                : ''
            "
            v-if="members[item.uid] && members[item.uid].code > 0"
            class="user"
          >
            <div class="head-bg">
              <img src="../../assets/img/others/3touming.png" alt="" />
              <div class="head-user">
                <img :src="members[item.uid].avatar" alt="" />
              </div>
              <div
                v-if="
                  state === 0 &&
                  members[item.uid] &&
                  members[item.uid].ready === true
                "
                class="ready"
              >
                准备
              </div>
              <div v-else>
                <span class="ready" style="color: #fff" v-if="state >= 1">{{
                  members[item.uid].integral
                }}</span>
              </div>
            </div>
            <!-- <span class="ready" style="color: #fff" v-if="state >= 1">{{members[item.uid].integral}}</span> -->
          </div>

          <img
            v-else
            class="default-img"
            src="../../assets/img/others/3.png"
            alt=""
          />
        </span>
      </div>

      <div class="zw_left_two clearfix">
        <span
          v-for="(item, index) in codes.left_bottom"
          @click="joinRoomCode(item.code)"
          :key="index"
        >
          <div
            :class="
              members[item.uid] && members[item.uid].isOnline === false
                ? 'leave'
                : ''
            "
            v-if="members[item.uid] && members[item.uid].code > 0"
            class="user"
          >
            <div class="head-bg">
              <img src="../../assets/img/others/3touming.png" alt="" />
            </div>
            <div class="head-user">
              <img :src="members[item.uid].avatar" alt="" />
            </div>
            <span class="ready" style="color: #fff" v-if="state >= 1">{{
              members[item.uid].integral
            }}</span>
            <div
              v-if="
                state === 0 &&
                members[item.uid] &&
                members[item.uid].ready === true
              "
              class="ready"
            >
              准备
            </div>
          </div>

          <div v-else>
            <img src="../../assets/img/others/3.png" alt="" />
          </div>
        </span>
      </div>
      <div class="zw_left_two two_right clearfix">
        <span
          v-for="(item, index) in codes.right_bottom"
          @click="joinRoomCode(item.code)"
          :key="index"
        >
          <div
            :class="
              members[item.uid] && members[item.uid].isOnline === false
                ? 'leave'
                : ''
            "
            v-if="members[item.uid] && members[item.uid].code > 0"
            class="user"
          >
            <div class="head-bg">
              <img src="../../assets/img/others/3touming.png" alt="" />
              <div class="head-user">
                <img :src="members[item.uid].avatar" alt="" />
              </div>
              <div
                v-if="
                  state === 0 &&
                  members[item.uid] &&
                  members[item.uid].ready === true
                "
                class="ready"
              >
                准备
              </div>
              <div v-else>
                <span class="ready" style="color: #fff" v-if="state >= 1">{{
                  members[item.uid].integral
                }}</span>
              </div>
            </div>
          </div>

          <div v-else>
            <img src="../../assets/img/others/3.png" alt="" />
          </div>
        </span>
      </div>



    <div class="console_bottom">


      <!-- 结果显示 -->
      <div class="res_list">
        <div class="clearfix" v-if="opens.length >= 0">
          <!-- <span class="res_list_left_num">1</span> -->
          <img
            v-for="(item, index) in opens"
            :src="opens_url[item.code]"
            alt=""
            v-if="index <= 5"
            :key="index"
          />
          <!-- <span class="res_list_right_num">6</span> -->
        </div>
        <div class="clearfix" v-if="opens.length >= 0">
          <!-- <span class="res_list_left_num">7</span> -->
          <img
            v-if="index >= 6"
            v-for="(item, index) in opens"
            :src="opens_url[item.code]"
            alt=""
            :key="index"
          />
          <!-- <span class="res_list_right_num">12</span> -->
        </div>
      </div>


      <!-- 准备 -->

      <div
        v-if="members[uid] && members[uid].code > 0 && members[uid].ready === false"
        class="zj_action"
      >
        <!-- <div class="text-tips">点击准备开始</div> -->
        <div class="btns1">
          <img v-clicked @click="ready" src="../../assets/img/others/zhunbei.png" alt="" class="btn-ready">
        </div>
      </div>





      <!-- 放宝 -->
      <div v-if="!playflag && run_state === 1" class="zj_action">
        <div class="btns">
          <span v-clicked @click="random"></span>
          <span v-clicked @click="banker_fangbao_start"></span>
        </div>
      </div>





      <!-- 抢庄 -->
      <div
        v-if="
          members[uid] &&
          members[uid].code > 0 &&
          members[uid].ready === true &&
          state === 1 &&
          +members[uid].is_rob_banker !== 1"
        class="zj_action">
        <div class="qiangzhuang">

          <span v-clicked @click="robBanker"></span>
          <span v-clicked @click="noRobBanker"></span>
        </div>
      </div>


      <!-- 庄家开奖 -->
      <div
        v-if="!playflag && run_state === 3 && is_open === false"
        class="zj_action"
      >
        <div class="kaijiang">
          <span v-clicked @click="open(1)"></span>
          <span v-clicked @click="open(0)"></span>
        </div>
      </div>



      <!-- 筹码 -->
      <div class="cm_list" v-if="playflag && run_state === 2 || true">
        <div class="btns">
          <span v-clicked @click="clearCanvas">0</span>
          <span v-clicked>停止下注</span>
        </div>
        <div class="cm_list_cont">
          <span v-for="(item, index) in cmList" :key="index">
            <img
              @click="changeCm($event, index)"
              v-clicked
              :class="cmActive == index ? 'active' : ''"
              :src="item"
              alt=""
            />
          </span>
        </div>
      </div>




    </div>





      <div style="clear: both"></div>
    </div>

    <div class="fonter">
      <span
        :class="index == 5 ? 'zb' : ''"
        @click.stop="changeMeun(index)"
        v-for="(item, index) in fontList"
        :key="index"
      >
        <img :src="item" alt="" />
      </span>
    </div>

    <img v-if="resFlag" :src="resList[resActive]" alt="" class="res_animate" />

    <message v-model="messageFlag"></message>

    <diglogx v-model="grinfo" class="bgs">
      <template v-slot:content>
        <div class="grinfo">
          <p class="z">
            致广大玩家:
            <br /><i style="padding-left: 40px"></i> 打开游戏后，
            如果发现游戏界面和之前玩的界面不一样，就肯定是山寨平台及外挂平台，请认准游戏界面，防伪签名，等级和ID，谨防被骗，海陆玩提示。
          </p>
          <p class="r">(我们的界面永远不会变)</p>
          <div class="f">
            <span>防作弊签名:</span>
            前面大
          </div>
          <div class="o">
            <span v-clicked>刷新头像</span>
            <div class="r">
              <img src="" alt="" />
              <div class="b">
                <p>
                  <i>昵称昵称</i>
                  <i>ID:229741</i>
                </p>
                <div>
                  <i>1级</i>
                  <span><i></i></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </diglogx>

    <diglogx v-model="sys">
      <template v-slot:content>
        <div class="sys">
          <ul>
            <li>
              <span>背景音乐</span>
              <span>
                <van-switch
                  style="position: relative; top: 5px"
                  active-color="#8DE04A"
                  v-model="checked.one"
                />
                开启
              </span>
            </li>
            <li>
              <span>游戏音效</span>
              <span>
                <van-switch
                  style="position: relative; top: 5px"
                  active-color="#8DE04A"
                  v-model="checked.two"
                />
                开启
              </span>
            </li>
          </ul>
        </div>
      </template>
    </diglogx>

    <zx v-model="zxflag" isalert></zx>

    <div class="k_res_list" @click="jls = false" v-if="jls">
      <div class="t">
        <img src="../../assets/img/play/2.png" alt="" />
        <ul>
          <li>出<span>X0</span></li>
          <li>虎<span>X0</span></li>
          <li>入<span>X0</span></li>
          <li>龙<span>X0</span></li>
        </ul>
      </div>
      <div class="j">
        <ul>
          <li v-for="(item, index) in 10" :key="index">
            <div class="b"></div>
            <div class="c">
              <span> 1 </span>
              <img src="../../assets/img/message/15.png" alt="" />
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { dramImg } from "./uitl";
import { fgList, qyList, fourBlock } from "./fg";
import { Dialog, Empty } from "vant";
import { Notify } from "vant";
import message from "./message.vue";
import index from "../../../../anbao/src/view/index/index.vue";
import zx from "../index/zx.vue";
//声音文件
let buqiang = require("_a/mp3/buqiang.mp3");
let chipMove = require("_a/mp3/chipMove.mp3");
let chu = require("_a/mp3/chu.mp3");
let fangbao = require("_a/mp3/fangbao.mp3");
let goldMove = require("_a/mp3/goldMove.mp3");
let hu = require("_a/mp3/hu.mp3");
let long = require("_a/mp3/long.mp3");
let qiangzhuang = require("_a/mp3/qiangzhuang.mp3");
let ru = require("_a/mp3/ru.mp3");
let tipBet = require("_a/mp3/tipBet.mp3");
let zhuangOpen = require("_a/mp3/zhuangOpen.mp3");

export default {
  components: { index, message, zx },
  data() {
    return {
      checked: {
        one: true,
        two: true,
      },
      messageFlag: false,
      playflag: true,
      jls: false,
      randomFlag: true,
      bgActive: 0,
      grinfo: false,
      zxflag: false,
      sys: false,
      canvasWidth: 0,
      bgList: [
        require("_a/img/others/00.png"),
        require("_a/img/others/0.png"),
        require("_a/img/others/11.png"),
        require("_a/img/others/33.png"),
      ],
      cmList: [
        require("_a/img/others/v.png"),
        require("_a/img/others/bb-vb.png"),
        require("_a/img/others/njhjj.png"),
        require("_a/img/others/gbggcvcv.png"),
        require("_a/img/others/nbb.png"),
      ],
      fontList: [
        require("_a/img/others/45.png"),
        require("_a/img/others/35.png"),
        require("_a/img/others/41.png"),
        require("_a/img/others/48.png"),
        require("_a/img/others/25.png"),
        require("_a/img/18.png"),
        require("_a/img/others/40.png"),
      ],
      resList: [
        require("_a/img/others/zc.png"), //龙
        require("_a/img/others/x.png"), //入
        require("_a/img/others/xh.png"), //虎
        require("_a/img/others/h.png"), //出
      ],
      resActive: 0,
      resFlag: false,
      cmposition: {
        top: "70%",
        left: "20%",
      },
      cmActive: 0,
      //wj
      ctx: null,
      fgOpacty: 0.1,
      paths: [],
      //zj
      zCtx: null,
      zpaths: [],
      //开奖速度
      openSpeend: 0.001,
      /* websocket */
      ws: null,
      room_id: 0,
      /* 会员 */
      uid: 0,
      //会员池
      members: [],
      //ws重连次数
      ws_connect: 0,
      /* 定时器 id */
      timing: 0,
      /* 心跳 --15秒发送一次心跳 */
      heartbeat: 15,
      //消息处理函数
      msgCallback: "",
      //数据处理函数
      dataCallback: "",
      //倒计时开关
      isCountDown: false,
      //倒计时
      time: 0,
      state: 0, // 0 创建初始化 1 抢庄中 2抢庄结束 3运行中 4结算中 5结算完成
      run_state: 0, // 0初始化 1庄家放宝方向倒计时 2玩家开始下注 3庄家开奖 4玩家结算 5结算中 6结算完成
      ready_time: 0, //准备抢庄倒计时
      rob_time: 0, //开始抢庄倒计时
      is_banker: false, //false 玩家 true 庄家,
      fangbao_time: 0, //放宝方向时间
      bet_time: 0, //玩家下注时间
      opening_time: 0, //庄家开奖时间
      code: 0, //庄家放宝
      chips: [10, 20, 30, 50, 100], //筹码
      bet_id: -1, //下注id
      run_number: 1, //运行的局数,
      //座位
      codes: [],
      click: false,
      is_open: false,
      opens: [],
      opens_url: [
        require("_a/img/others/l.png"),
        require("_a/img/others/ru.png"),
        require("_a/img/others/hu.png"),
        require("_a/img/others/chu.png"),
      ],
      imgResult: 0,
    };
  },

  computed: {
    getwh() {
      return function (num, type) {
        if (type == 0) {
          return (screen.height - 80) / num + "px";
        }
      };
    },
    getStyle() {
      return function (length, index, type = 0) {
        let top = -10;
        let h = 0;
        if (type == 0) {
          let left = document.querySelector(".zw_left span");
          let cH = document.body.clientHeight;

          if (left) {
            left = (left.offsetHeight / cH) * 100;
          }
          top = 0;
          if (length >= 12) {
            h = left ? left + 0.478 : 4.782;
          }
          if (length >= 14) {
            h = left ? left + 7 : 40;
          }
          // console.log(left);
          return {
            top: h * index + top + "vh",
          };
        }
      };
    },
  },
  created() {
    this.room_id = this.getUrlKey("room_id") || 0;
    this.uid = this.getUrlKey("uid");
    if (this.room_id <= 0) {
      Notify({ type: "danger", message: "房间id错误!" });
      return;
    }
  },
  beforeRouteLeave(to, form, next) {
    this.clear();
    next();
  },

  mounted() {
    document.addEventListener("click", () => {
      this.messageFlag = false;
    });
    if (this.room_id > 0) {
      this.initWebsocket();
    }

    this.init();
    this.zinit(this.fourBlock);
  },
  methods: {
    //获取路由的key
    getUrlKey: function (name) {
      var url = window.location.href;
      let params = url.substr(url.lastIndexOf("?") + 1).split("&");
      for (let i = 0; i < params.length; i++) {
        let param = params[i];
        let key = param.split("=")[0];
        let value = param.split("=")[1];
        if (key === name) {
          return value;
        }
      }
    },

    copy() {
      var url = "60人游戏:" + window.location.href;
      var input = document.createElement("input"); // 直接构建input
      input.value = url; // 设置内容
      document.body.appendChild(input); //添加临时实例
      input.select(); // 选择实例内容
      document.execCommand("Copy"); // 执行复制
      document.body.removeChild(input);
      Notify({ type: "success", message: "复制成功!" });
    },

    /* 初始化websocket */
    initWebsocket() {
      let _this = this;
      _this.ws = new WebSocket(this.wsUrl);
      //连接回调
      _this.ws.onopen = function () {
        console.log("--------------websocket连接成功-----------------");
      };

      _this.ws.onmessage = function (evt) {
        var received_msg = eval("(" + evt.data + ")");
        //初始鉴权
        if (received_msg.type === "init") {
          //调用鉴权
          _this.checkAuth(received_msg.client_id);
          //启动定时器
          _this.global_timing();
        }
        /* 消息提醒--开始 */
        if (received_msg.hasOwnProperty("msg")) {
          //统一处理函数
          _this.msgCallback = "_this.msg";
          eval(_this.msgCallback)(received_msg.type, received_msg.msg);
        }
        /* 消息提醒--结束 */

        /* 数据处理--开始 */
        if (received_msg.hasOwnProperty("data")) {
          //统一处理函数
          _this.dataCallback = "_this." + received_msg.call;
          eval(_this.dataCallback)(received_msg.data);
        }
        /* 数据处理--结束 */
      };

      //错误时说明
      _this.ws.onerror = function (e) {
        Notify({
          type: "danger",
          message: "游戏服务器异常错误!!!!",
        });
        console.log(e, "error");
      };

      //关闭链接
      _this.ws.onclose = function (e) {
        _this.clear();
      };
    },

    /* 清除定时器 window.clearInterval(f); */
    clear() {
      //清除定时器
      window.clearInterval(this.timing);
      //关闭websocket
      if (this.room_id > 0) {
        this.ws.close();
      }
    },

    /* 全局定时器 */
    global_timing() {
      let _this = this;
      //说明已经调用了一次定时器
      if (this.timing !== 0) {
        return;
      }
      this.timing = setInterval(() => {
        /* 心跳逻辑--开始 */
        _this.heartbeat -= 1;
        if (_this.heartbeat <= 0) {
          _this.heartbeat = 15;
          //调用心跳
          _this.checkHeartbeat();
        }
        /* 心跳逻辑--结束 */

        /* 倒计时逻辑 */

        //准备抢庄倒计时倒计时
        if (+_this.state === 0 && _this.ready_time >= 0) {
          _this.time = _this.ready_time;
          _this.ready_time -= 1;
          if (_this.ready_time <= -1) {
            _this.ready_time = 30;
            _this.isCountDown = false;
          }
        }

        //开始抢庄倒计时
        if (+_this.state === 1 && _this.rob_time >= 0) {
          _this.time = _this.rob_time;
          _this.rob_time -= 1;
          if (_this.rob_time <= -1) {
            _this.rob_time = 30;
            _this.isCountDown = false;
          }
        }

        /* 游戏逻辑开始 */
        if (+_this.state === 3) {
          //0初始化 1庄家放宝方向倒计时 2玩家开始下注 3庄家开奖 4玩家结算 5结算中 6结算完成

          //庄家放宝
          if (+_this.run_state === 1 && _this.fangbao_time >= 0) {
            if (_this.fangbao_time >= 15) {
              _this.clearCanvas();
              _this.is_open = false;
            }
            _this.time = _this.fangbao_time;
            _this.fangbao_time -= 1;
            if (_this.fangbao_time <= -1) {
              _this.fangbao_time = 15;
              _this.isCountDown = false;
            }
          }
          //玩家下注逻辑
          if (+_this.run_state === 2 && _this.bet_time >= 0) {
            // console.log("aa", _this.bet_time);
            _this.time = _this.bet_time;
            _this.bet_time -= 1;
            if (_this.bet_time <= -1) {
              _this.bet_time = 30;
              _this.isCountDown = false;
            }
          }
          //庄家开奖倒计时逻辑
          if (+_this.run_state === 3 && _this.opening_time >= 0) {
            _this.time = _this.opening_time;
            _this.opening_time -= 1;
            if (_this.opening_time <= -1) {
              _this.opening_time = 30;
              _this.isCountDown = false;
            }
          }
          //结算倒计时
          if (+_this.run_state === 4 && _this.settlement_time >= 0) {
            _this.time = _this.settlement_time;
            _this.settlement_time -= 1;
            if (_this.settlement_time <= -1) {
              _this.settlement_time = 10;
              _this.isCountDown = false;
            }
          }
        }

        /* 倒计时逻辑--结束 */
      }, 1000); //一秒钟执行一次
    },
    /* 用户接口 */
    checkAuth(client_id) {
      let _this = this;
      let openid = localStorage.getItem("_openid") || false;
      _this.$axios
        .post("user/bind", {
          client_id: client_id,
          openid: openid,
        })
        .then(function (response) {
          //走登入逻辑
          if (+response.data.code === 10000) {
            return;
          }
          if (+response.data.code === 10001) {
            Dialog.alert({
              message: response.data.msg,
            }).then(() => {
              // on close
            });
            return;
          }
          if (+response.data.code === 200) {
            _this.uid = response.data.data.uid;
            _this.checkRoom();
            return;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    /* 校验房间 */
    checkRoom() {
      let _this = this;
      let openid = localStorage.getItem("_openid") || false;
      this.$axios
        .get("/user/check/room", {
          params: { room_id: _this.room_id, openid: openid },
        })
        .then(function (response) {
          if (+response.data.code === 10000) {
            Dialog.alert({
              message: response.data.msg,
            }).then(() => {
              _this.$router.push("/auth");
            });
            return;
          }
          if (+response.data.code === 10001) {
            Notify({ type: "danger", message: response.data.msg });
            _this.ws.close();
            return;
          }
          if (+response.data.code === 200) {
            response.data.data.code.left = response.data.data.code.left.slice(
              0,
              13
            );
            response.data.data.code.right = response.data.data.code.right.slice(
              0,
              13
            );
            response.data.data.code.right_bottom = [];
            response.data.data.code.left_bottom = [];
            response.data.data.code.top = response.data.data.code.top.slice(
              0,
              6
            );
            response.data.data.code.bottom = response.data.data.code.bottom.slice(
              0,
              6
            );
            _this.codes = response.data.data.code;
            _this.joinRoom();
            return;
          }
          if (+response.data.code === 10002) {
            //已经完成,走跳转逻辑
            Dialog.alert({
              message: "已经结算完成。直接跳转结算页面",
            }).then(() => {
              // on close
            });
            _this.ws.close();
            return;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    /* ws:逻辑  */
    //发送
    send(data) {
      let _this = this;
      let base = { uid: _this.uid, room_id: _this.room_id };
      let send_data = Object.assign(base, data);
      _this.ws.send(JSON.stringify(send_data));
    },
    //警告消息
    msg(type, msg) {
      Notify({ type: type, message: msg });
      return;
    },
    //会员数据
    send_room_members(res) {
      let data = res;
      let members = data;

      for (let i in members) {
        //会员数据键值对
        members[members[i].uid] = members[i];
        //座位处理
        if (members[i].hasOwnProperty("code")) {
          for (let k in this.codes) {
            for (let j in this.codes[k]) {
              if (this.codes[k][j].code == members[i].code) {
                this.codes[k][j].uid = members[i].uid;
              }
            }
          }
        } else {
          members[i].code = 0;
        }
      }
      this.members = members;
      console.log(this.members);
    },
    //心跳检测
    checkHeartbeat() {
      this.send({ type: "ping" });
    },
    //加入房间
    joinRoom() {
      this.send({ type: "join_room" });
    },
    //加入座位
    joinRoomCode(code) {
      this.send({ type: "join_room_code", code: code });
    },
    //广播准备消息
    send_room_ready_data(res) {
      let data = res;

      for (let i in data) {
        this.members[i].ready = true;
      }
      console.log("推送准备消息");
    },
    //准备
    ready() {
      this.send({ type: "ready" });
    },
    //房间方宝方向操作
    banker_fangbao_start() {
      if (this.is_banker && this.code >= 0) {
        this.send({ type: "banker_fangbao_start", code: this.code });
      }
    },
    //准备抢庄倒计时
    send_room_ready(res) {
      let data = res;
      this.ready_time = data.ready_time;
      this.state = data.state;
      this.isCountDown = true;
    },
    //抢庄倒计时
    send_room_rob_banker_time(res) {
      let data = res;
      this.rob_time = data.rob_time;
      this.state = data.state;
      this.isCountDown = true;
      console.log("抢庄倒计时");
    },
    //抢庄
    robBanker() {
      this.send({ type: "rob_banker" });
    },
    rob_banker_data(res) {
      let data = res;
      console.log(data, "抢庄消息");
    },
    //抢庄结果
    send_room_rob_banker_result(res) {
      //修改庄家
      if (+res.uid === +this.uid) {
        this.is_banker = true;
        this.playflag = false;
      }
      this.state = res.state;
    },
    //庄家开始放宝
    send_room_banker_start(res) {
      let data = res;
      this.fangbao_time = data.fangbao_time;
      this.run_state = data.run_state;
      this.isCountDown = true;
      this.run_number = data.run_number;
      //清除注码
      this.activeFg(1);
      console.log("庄家放宝倒计时");
    },
    //玩家下注广播
    send_room_bet_start(res) {
      let data = res;
      this.bet_time = data.bet_time;
      this.run_state = data.run_state;
      this.isCountDown = true;
      this.run_number = data.run_number;
      console.log("玩家下注逻辑");
    },
    send_bet(x, y, x1, y1, cmActive, w, h) {
      let chip = this.chips[this.cmActive] || -1;
      if (chip <= 0) {
        this.msg("warning", "筹码错误!!");
        return;
      }
      if (this.bet_id < 0) {
        this.msg("warning", "下注错误!!");
        return;
      }
      this.send({
        type: "bet",
        chip: chip,
        bet_id: this.bet_id,
        x: x,
        y: y,
        x1: x1,
        y1: y1,
        cmActive: cmActive,
        w: w,
        h: h,
      });
    },
    //下注记录
    send_room_bet(res) {
      let data = res;
      let bet_log = data.bet_log;
      console.log(bet_log, "aaaa");
      for (let i in bet_log) {
        this.bet_animation(
          bet_log[i].x,
          bet_log[i].y,
          bet_log[i].x1,
          bet_log[i].y1,
          bet_log[i].cmActive,
          bet_log[i].w,
          bet_log[i].h
        );
      }
    },
    //庄家开奖倒计时
    send_room_banker_ready_prize(res) {
      let data = res;
      this.opening_time = data.opening_time;
      this.run_state = data.run_state;
      this.isCountDown = true;
      this.run_number = data.run_number;
      console.log("庄家开奖倒计时逻辑");
    },
    //庄家开奖结果
    send_room_banker_draw_prize(res) {
      let data = res;
      this.opening_log = data.opening_log;
      this.opening = data.opening;
      this.run_number = data.run_number;
      this.$play(zhuangOpen);
    },
    //庄家开奖后倒计时
    send_room_settlement(res) {
      let data = res;
      this.settlement_time = data.settlement_time;
      this.run_state = data.run_state;
      this.isCountDown = true;
      this.run_number = data.run_number;
      console.log("庄家开奖结算倒计时", "进行中的局数:" + data.run_number);
    },
    //结算广播
    send_settlement(res) {
      let data = res;
      let settlement = data.settlement;
      console.log(settlement, "小局结算--结算逻辑");
      //开始处理结算的结果
      for (let i in settlement) {
        this.members[settlement[i].uid].integral = settlement[i].money;
      }
    },
    //结算完成跳转到结算页面
    send_end(res) {
      let data = res;
      console.log("结算完成,跳转结算页面");
    },
    //开奖
    open(type) {
      this.send({ type: "open", banker_open: type });
    },
    //开奖广播
    send_open(res) {
      let data = res;
      if (+data.type === 1) {
        //快开
        this.openSpeend = 0.002;
      } else {
        //慢
        this.openSpeend = 0.001;
      }
      this.resActive = data.resActive.code;
      if (this.resActive === 0) {
        this.$play(long);
      }
      if (this.resActive === 1) {
        this.$play(ru);
      }
      if (this.resActive === 2) {
        this.$play(hu);
      }
      if (this.resActive === 3) {
        this.$play(chu);
      }
      this.is_open = true;
      this.centerOpen(data.resActive.code);
      let _this = this;
    },
    //开奖结果
    send_open_log(res) {
      let data = res;
      this.opens = data.open_log;
      console.log("open_log", this.opens);
    },
    //开奖结果图片方向适配器
    resultWatch(num) {
      console.log("开奖结果图片图片");
      document.querySelector("#can .result-img").style.transform = `rotate(${
        -num * 90
      }deg)`;
    },

    /* ws:逻辑结束 */

    //wj
    init() {
      let canvas = document.getElementById("game");
      let width = document.querySelector("#can").offsetWidth;
      canvas.width = width;
      canvas.height = width;
      let ctx = canvas.getContext("2d");
      this.ctx = ctx;
      this.canvasWidth = width;

      dramImg(require("../../assets/img/others/8.png"), (res3) => {
        ctx.drawImage(
          res3,
          width * 0.38,
          width * 0.38,
          width * 0.25,
          width * 0.25
        );

        this.fglist();

        setTimeout(() => {
          // this.centerOpen();
          //   this.activeFg(1)
        }, 2000);
      });
    },

    fglist() {
      let w = document.querySelector("#can").offsetWidth;
      let paths = [];
      this.ctx.beginPath();
      fgList.forEach((item) => {
        let path = new Path2D();
        item.position.forEach((tt, ti) => {
          path.lineTo((tt[0] / 290) * w, (tt[1] / 290) * w);
        });
        paths.push({
          path,
          id: item.id,
          position: item.position,
          imgPosition: item.imgPosition,
        });
        this.ctx.strokeStyle = "transparent";
        this.ctx.fillStyle = "transparent";
        this.ctx.fill(path);
        this.ctx.stroke(path);
        this.ctx.closePath();
      });
      this.paths = paths;
      //   this.activeFg()
      let _this = this;

      if (_this.click) {
        return;
      }
      _this.click = true;
      document.getElementById("game").addEventListener("click", (e) => {
        // var bbox = document.getElementById("game").getBoundingClientRect();
        _this.bet(e.layerX, e.layerY, e.clientX, e.clientY);
      });
    },
    clearCanvas() {
      //console.log(123)
      this.ctx.clearRect(0, 0, this.canvasWidth, this.canvasWidth);
      this.init();
    },
    //下注
    bet(x1, y1, x2, y2) {
      let w = document.querySelector("#can").offsetWidth;
      let h = document.querySelector("#can").offsetHeight;
      let _this = this;
      this.paths.forEach((item, index) => {
        let x = x1; // e.layerX; //-bbox.left
        let y = y1; // e.layerY; //-bbox.top
        if (this.ctx.isPointInPath(item.path, x, y)) {
          if (_this.run_state === 2 && _this.is_banker === false) {
            _this.bet_id = item.id;
            _this.send_bet(x1, y1, x2, y2, _this.cmActive, w, h);
          }

          //console.log(item.id)
          //console.log(e)
          //console.log(x)

          //   var getbl = (value) => {
          //     return (value / 290) * w;
          //   };
          //   if (item.id < 30) {
          //     if (x < getbl(item.imgPosition.x.min)) {
          //       x = getbl(item.imgPosition.x.min);
          //     }
          //     if (x > getbl(item.imgPosition.x.max)) {
          //       x = getbl(item.imgPosition.x.max);
          //     }
          //     if (y < getbl(item.imgPosition.y.min)) {
          //       y = getbl(item.imgPosition.y.min);
          //     }
          //     if (y > getbl(item.imgPosition.y.max)) {
          //       y = getbl(item.imgPosition.y.max);
          //     }
          //   } else {
          //     console.log(y, item.id);
          //     let obj = item.imgPosition.filter((item) => {
          //       return y >= item.y[0] && y <= item.y[1];
          //     })[0];
          //     console.log(obj);
          //     y = obj.y[0] + 5;

          //     if (x < getbl(obj.x[0])) {
          //       x = getbl(obj.x[0]);
          //     }
          //     if (x > getbl(obj.x[1])) {
          //       x = getbl(obj.x[1]);
          //     }
          //   }

          //   let aimg = new Image(); //document.querySelector(".animate")
          //   let id = "id" + index;
          //   aimg.src = this.cmList[this.cmActive];
          //   aimg.id = id;
          //   aimg.className = "animate";
          //   aimg.style.top = this.cmposition.top;
          //   aimg.style.left = this.cmposition.left;
          //   document.querySelector(".view_play").appendChild(aimg);

          //   aimg.onload = () => {
          //     aimg.style.opacity = 1;
          //     aimg.style.transition = "all 0.5s";
          //     aimg.style.top = y2 + "px";
          //     aimg.style.left = x2 + "px";

          //     setTimeout(() => {
          //       let allimg = document.querySelectorAll(".view_play .animate");
          //       allimg.forEach((tt, ti) => {
          //         tt.remove();
          //       });
          //       dramImg(this.cmList[this.cmActive], (res) => {
          //         this.ctx.drawImage(res, x, y, getbl(25), getbl(25));
          //       });
          //     }, 500);
          //   };
        }
      });
    },
    bet_animation(x1, y1, x2, y2, cmActive, to_w, to_h) {
      let w = document.querySelector("#can").offsetWidth;
      let h = document.querySelector("#can").offsetHeight;

      //计算多个屏幕的 下注坐标点计算
      if (w > to_w) {
        let n = w - to_w;
        let px = w / 100;
        let r = n / px;
        x1 = x1 + x1 * r * 0.01;
        x2 = x2 + x2 * r * 0.01;
      }
      if (w < to_w) {
        let n = to_w - w;
        let px = to_w / 100;
        let r = n / px;
        x1 = x1 - x1 * r * 0.01;
        x2 = x2 - x2 * r * 0.01;
      }

      //计算y轴
      if (h > to_h) {
        let ny = h - to_h;
        let px1 = h / 100;
        let r1 = ny / px1;
        y1 = y1 + y1 * r1 * 0.01;
        y2 = y2 + y2 * r1 * 0.01;
      }
      if (h < to_h) {
        let ny = to_h - h;
        let px1 = to_h / 100;
        let r1 = ny / px1;
        y1 = y1 - y1 * r1 * 0.01;
        y2 = y2 - y2 * r1 * 0.01;
      }

      let _this = this;
      this.paths.forEach((item, index) => {
        let x = x1; // e.layerX; //-bbox.left
        let y = y1; // e.layerY; //-bbox.top

        if (this.ctx.isPointInPath(item.path, x, y)) {
          var getbl = (value) => {
            return (value / 290) * w;
          };
          if (item.id < 30) {
            if (x < getbl(item.imgPosition.x.min)) {
              x = getbl(item.imgPosition.x.min);
            }
            if (x > getbl(item.imgPosition.x.max)) {
              x = getbl(item.imgPosition.x.max);
            }
            if (y < getbl(item.imgPosition.y.min)) {
              y = getbl(item.imgPosition.y.min);
            }
            if (y > getbl(item.imgPosition.y.max)) {
              y = getbl(item.imgPosition.y.max);
            }
          } else {
            console.log(y, item.id);
            let obj = item.imgPosition.filter((item) => {
              return y >= item.y[0] && y <= item.y[1];
            })[0];
            console.log(obj);
            y = obj.y[0] + 5;

            if (x < getbl(obj.x[0])) {
              x = getbl(obj.x[0]);
            }
            if (x > getbl(obj.x[1])) {
              x = getbl(obj.x[1]);
            }
          }

          let aimg = new Image(); //document.querySelector(".animate")
          let id = "id" + index;
          aimg.src = this.cmList[cmActive];
          aimg.id = id;
          aimg.className = "animate";
          aimg.style.top = this.cmposition.top;
          aimg.style.left = this.cmposition.left;
          document.querySelector(".view_play").appendChild(aimg);

          aimg.onload = () => {
            aimg.style.opacity = 1;
            aimg.style.transition = "all 0.5s";
            aimg.style.top = y2 + "px";
            aimg.style.left = x2 + "px";

            setTimeout(() => {
              let allimg = document.querySelectorAll(".view_play .animate");
              allimg.forEach((tt, ti) => {
                tt.remove();
              });
              dramImg(this.cmList[cmActive], (res) => {
                this.ctx.drawImage(res, x, y, getbl(25), getbl(25));
              });
            }, 500);
          };
        }
      });
    },
    //选中动画
    activeFg(type = 0) {
      //type 0 选中  ， 1 清除
      let w = document.querySelector("#can").offsetWidth;
      //let active = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,30,31,32,33]
      let active = [0, 1, 3, 2, 30, 32];
      this.paths.forEach((item) => {
        if (active.includes(item.id)) {
          //item.position
          if (type == 1) {
            this.ctx.clearShape(item.position, w);
            return;
          }
          let opacity = 0.1;

          var animation = () => {
            requestAnimationFrame(() => {
              opacity += 0.01;
              this.ctx.clearShape(item.position, w);
              this.ctx.fillStyle = `rgba(247, 190, 183,${opacity})`;
              //this.ctx.strokeStyle=`rgba(247, 190, 183,${opacity})`
              this.ctx.fill(item.path);
              this.ctx.stroke(item.path);
              if (opacity <= 0.7) {
                animation();
              }
            });
          };
          animation();
        }
      });
    },

    //中间的动画
    centerOpen(num) {
      console.log("开奖结果图片图片", num);
      let width = document.querySelector("#can").offsetWidth;
      let left = 0.38;
      let img = new Image();
      img.src = require("../../assets/img/others/8.png");
      let _this = this;
      img.onload = () => {
        let s = setInterval(() => {
          if (left >= 0.6) {
            _this.resFlag = true;
            clearInterval(s);
          }
          dramImg(
            require(`../../assets/img/others/shabi_${num}.png`),
            (res3) => {
              this.ctx.clearRect(
                width * left,
                width * 0.385,
                width * 0.24,
                width * 0.24
              );
              this.ctx.drawImage(
                res3,
                width * 0.38,
                width * 0.38,
                width * 0.25,
                width * 0.25
              );
              left += this.openSpeend;
              this.ctx.drawImage(
                img,
                width * left,
                width * 0.38,
                width * 0.25,
                width * 0.25
              );
            }
          );
        }, 10);

        setTimeout(() => {
          _this.resFlag = false;
        }, 6000);
      };
    },

    changeCm(e, index) {
      this.cmActive = index;
      this.cmposition = {
        top: e.clientY + "px",
        left: e.clientX + "px",
      };

      console.log(e);
    },

    changeMeun(index) {
      switch (index) {
        case 0:
          this.$router.push("/index");
          break;
        case 1:
          this.bgActive++;
          if (this.bgActive > 3) {
            this.bgActive = 0;
          }
          break;
        case 2:
          this.sys = true;
          break;
        case 3:
          this.zxflag = true;
          break;
        case 4:
          this.jls = true;
          break;
        case 5:
          this.grinfo = true;
          break;
        case 6:
          this.messageFlag = true;
          break;
      }
    },

    //zj
    zinit(callback) {
      let canvas = document.getElementById("zgame");
      let width = document.querySelector("#can").offsetWidth;
      canvas.width = width;
      canvas.height = width;
      let ctx = canvas.getContext("2d");
      this.zCtx = ctx;
      callback ? callback() : "";
      /* dramImg(require("../../assets/img/others/23.png"),(res3)=>{
					ctx.drawImage(res3,width*0.4,width*0.4,width*0.2,width*0.2);
					 callback?callback():''
				}) 	 */
      /* dramImg(require("../../assets/img/others/j.png"),(res)=>{
					ctx.drawImage(res,0,0,width,width);

				}) */
    },
    //四个区域
    fourBlock() {
      let w = document.querySelector("#can").offsetWidth;

      let paths = [];
      this.zCtx.beginPath();
      fourBlock.forEach((item) => {
        let path = new Path2D();
        item.position.forEach((tt, ti) => {
          path.lineTo((tt[0] / 290) * w, (tt[1] / 290) * w);
        });
        paths.push({
          path,
          id: item.id,
          position: item.position,
        });
        this.zCtx.strokeStyle = "transparent";
        this.zCtx.fillStyle = "transparent";
        this.zCtx.fill(path);
        this.zCtx.stroke(path);
        this.zCtx.closePath();
      });
      this.zpaths = paths;

      document.getElementById("zgame").addEventListener("click", (e) => {
        var bbox = document.getElementById("zgame").getBoundingClientRect();
        this.zpaths.forEach((item, index) => {
          let x = e.layerX; //-bbox.left
          let y = e.layerY; //-bbox.top

          this.zCtx.clearShape(item.position, w);

          if (this.ctx.isPointInPath(item.path, x, y)) {
            //填充
            let opacity = 0.1;

            var animation = () => {
              requestAnimationFrame(() => {
                opacity += 0.02;
                this.zCtx.clearShape(item.position, w);
                this.zCtx.fillStyle = `rgba(255, 120, 110,${opacity})`;
                this.zCtx.fill(item.path);
                if (opacity <= 0.5) {
                  animation();
                }
              });
            };
            animation();
            this.centerRotate(item.id);
            console.log(item.id);
            this.code = item.id;
          }
        });
      });
    },

    //random
    random() {
      if (!this.randomFlag) {
        return;
      }
      this.randomFlag = false;
      setTimeout(() => {
        this.randomFlag = true;
      }, 1000);
      let num = Math.floor(Math.random() * fourBlock.length);
      let id = fourBlock.map((item) => item.id)[num];
      this.code = id;
      this.banker_fangbao_start();
      let w = document.querySelector("#can").offsetWidth;
      this.zpaths.forEach((item, index) => {
        this.zCtx.clearShape(item.position, w);

        if (item.id == id) {
          //填充
          let opacity = 0.1;

          var animation = () => {
            requestAnimationFrame(() => {
              opacity += 0.02;
              this.zCtx.clearShape(item.position, w);
              this.zCtx.fillStyle = `rgba(247, 190, 183,${opacity})`;
              this.zCtx.fill(item.path);
              if (opacity <= 0.5) {
                animation();
              } else {
              }
            });
          };
          animation();
          this.centerRotate(num);
        }
      });
    },
    centerRotate(num) {
      document.querySelector("#can .gameb").style.transform = `rotate(${
        -num * 90
      }deg)`;
      /* return
				let width = document.querySelector("#can").offsetWidth
				this.zCtx.clearRect(width*0.4,width*0.4,width*0.2,width*0.2);
				this.zCtx.rotate(90*num*Math.PI/180);

					let img = new Image()
					img.src = require("")

					img.onload = () => {
						this.zCtx.drawImage(img,width*0.4,width*0.4,width*0.2,width*0.2);
						this.zCtx.rotate(0*Math.PI/180);
					}
					 */
    },
  },
};
</script>

<style lang="less" scoped="scoped">
.head-bg {
  width: 100%;
  height: 100%;
  img {
    width: 100%;
  }
}
.head-user {
  width: 100%;
  height: 3.107vh;
  position: absolute;
  top: 2px;
  z-index: 100;
  img {
    height: 100% !important;
    width: 90% !important;
  }
}
.view_play {
  .bg {
    display: block;
    width: 100%;
    height: 100vh;
  }
  .tra {
    transform: rotate(180deg);
  }
  .sys {
    ul {
      padding: 30px;
      padding-bottom: 60px;
      li {
        margin-bottom: 20px;
        span {
          font-size: 22px;
        }
        span:last-child {
          margin-left: 40px;
        }
      }
    }
  }
  .k_res_list {
    position: fixed;
    right: 0;
    bottom: 10vh;
    width: 40vw;
    border-radius: 5px;
    overflow: hidden;
    z-index: 1000;
    background-color: rgba(0, 0, 0, 0.5);
    .t {
      position: relative;
      img {
        display: block;
        width: 100%;
      }
      ul {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        color: #fff;
        padding-top: 10px;
        li {
          font-size: 16px;
          float: left;
          width: 50%;
          text-align: center;
        }
      }
    }
    .j {
      padding: 5px 0;
      height: 60vh;
      box-sizing: border-box;
      overflow-y: auto;
      ul {
        li {
          overflow: hidden;
          position: relative;
          height: 60px;
          margin-bottom: 5px;
          div.b {
            position: absolute;
            left: 32%;
            top: -87%;
            height: 40vw;
            width: 60px;
            background: url(../../assets/img/play/16.png) no-repeat 0 0;
            background-size: 100% 100%;
            transform: rotate(-90deg);
          }
          .c {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            text-align: center;
            span {
              float: left;
              font-size: 20px;
              line-height: 60px;
              padding-left: 8px;
              color: #fedb32;
            }
            img {
              display: inline-block;
              height: 60%;
              margin-top: 10%;
            }
          }
        }
      }
    }
  }
  .grinfo {
    padding: 20px;
    .z {
      color: #bf28ff;
      font-size: 20px;
    }
    & > .r {
      color: red;
      font-size: 20px;
      padding-top: 10px;
      text-align: center;
    }
    .f {
      padding-left: 30px;
      font-size: 20px;
      color: #e88185;
      padding: 10px 0;
      border-bottom: 1px solid #99aff1;
      span {
        color: #904e12;
      }
    }

    .o {
      padding-top: 10px;
      & > span {
        text-align: center;
        line-height: 35px;
        display: inline-block;
        width: 100px;
        height: 35px;
        color: #fff;
        background: url(../../assets/img/gr/btn.png) no-repeat 0 0;
        background-size: 100% 100%;
      }
      .r {
        padding-top: 10px;
        display: flex;
        & > img {
          width: 80px;
          height: 80px;
          background-color: #ccc;
        }
        .b {
          flex: 1;
          width: 100%;
          padding-left: 10px;
          p {
            color: #a57143;
            display: flex;
            margin-bottom: 10px;
            font-size: 20px;
            i {
              overflow: hidden;
              flex: 1;
            }
          }
          div {
            padding-top: 10px;
            display: flex;
            & > i {
              width: 40px;
              color: red;
              font-size: 20px;
            }
            span {
              margin-top: 5px;
              flex: 1;
              margin-left: 40px;
              width: 100%;
              overflow: hidden;
              height: 16px;
              border-radius: 20px;
              background-color: #d8b99a;
              i {
                display: block;
                width: 33%;
                height: 100%;
                background-color: #8ff352;
              }
            }
          }
        }
      }
    }
  }

  .copylink {
    left: 2.5vw;
    top: 6vh;
    position: fixed;
    z-index: 10000;
    width: 17.4vw;
    border-radius: 39.44vw;
    border: 1px solid #ded5b6;
    text-align: center;
    color: #ded5b6;
    font-size: 12px;
    height: 3.059vh;
    line-height: 3.059vh;
    background-color: rgba(24, 22, 22, 0.15);
  }
  .main {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;

    .tops {
      background: url(../../assets/img/others/t.png) no-repeat 0 0;
      background-size: 100% 100%;
      width: 96.29vw;
      margin: 0 auto;
      // padding: 14px 40px;
      height: 4.3vh;
      box-sizing: border-box;
      color: rgba(255, 255, 255, 0.7);
      position: relative;
      .top_info {
        width: 39.44vw;
        border-radius: 39.44vw;
        height: 3vh;
        background-color: rgba(0, 0, 0, 0.5);
        text-align: center;
        line-height: 3vh;
        margin: 0 auto;
        position: absolute;
        left: 30.46vw;
        top: 0.478vh;
        font-weight: bold;
      }
      span {
        display: inline-block;
      }
      div {
        display: inline-block;
        i {
          font-size: 12px;
          display: inline-block;
          text-align: left;
        }
        i:first-child {
          width: 50px;
        }
      }
      span:first-child {
        margin-left: 8.333vw;
        line-height: 4.3vh;
        height: 4.3vh;
        font-weight: bold;
      }
      span:last-child {
        width: 11.11vw;
        height: 3vh;
        margin-top: 0.478vh;
        background: url(../../assets/img/others/g.png) no-repeat 0 0;
        background-size: 100% 100%;
        float: right;
        margin-right: 8.333vw;
      }
    }
    .play {
      position: relative;
      margin-top: 18vh;
      .z {
        position: absolute;
        left: 50%;
        top: 0;
        transform: translate(-50%, -100%);
        img {
          display: block;
          width: 12.5vw;
        }
        span {
          position: absolute;
          color: red;
          left: 50%;
          top: 50%;
          transform: translate(-50%, -30%);
          font-weight: bold;
          font-size: 18px;
        }
      }
      .can {
        text-align: center;
        width: 72.407vw;

        margin: auto;
        position: relative;
        #zgame {
          background: url(../../assets/img/others/j.png) no-repeat 0 0;
          background-size: 100% 100%;
        }
        #game {
          background: url(../../assets/img/others/2.png) no-repeat 0 0;
          background-size: 100% 100%;
          position: relative;
          z-index: 10;
        }
        .gamea {
          position: absolute;
          z-index: 1;
          width: 46.5%;
          height: 45.3%;
          left: 26.8%;
          top: 26.3%;
        }
        .gameb {
          position: absolute;
          z-index: 1;
          width: 20%;
          height: 20%;
          left: 40%;
          top: 40%;
          transition: all 0.5s;
        }
        .result-img {
          position: absolute;
          z-index: 1;
          width: 20%;
          height: 20%;
          left: 40%;
          top: 40%;
          transition: all 0.5s;
        }
      }
    }
    .res_list {
      width: 50vw;
      left: 0;
      right: 0;
      margin: auto;
      margin-bottom: 0.478vh;
      position: absolute;

      div {
        background-color: rgba(0, 0, 0, 0.4);
        margin-bottom: 1px;
        height: 4.5vh;
        padding-left: 1.2vw;

        border-radius: 5px;
        img {
          float: left;
          width: 6.11vw;
          height: 2.868vh;
          margin-left: 1.2vw;
          margin-top: 2px;
        }
      }
    }
    .zj_action {
      // display: flex;
      width: 100%;
            position: absolute;
      margin: auto;
      z-index: 9999;
      .btns {
        margin: 0 auto;
        width: 50%;
        display: flex;

        span {
          flex: 1;
              height: 4.87vh;
    margin-top:12.8vh;
        }
        span {
          width: 22.77vw;
          background: url(../../assets/img/others/kkg.png) no-repeat 0 0;
          background-size: 100% 100%;
        }
        span:last-child {
          margin-left: 4.166vw;
          width: 22.77vw;
          background: url(../../assets/img/others/queding.png) no-repeat 0 0;
          background-size: 100% 100%;
        }
      }
      
      .btns1 {
        margin: 0 auto;
        width: 50%;
        display: flex;
        justify-content: space-between;
        .btn-cont {
          margin-top: 10.99vh;
          height: 32px;
          width: 60%;
          line-height: 32px;
          color: rgb(105, 68, 26);
          font-size: 18px;
          font-weight: bold;
          // background-color: #f0b83c;
          border-radius: 6px;
          text-align: center;
          letter-spacing: 10px;
          text-indent: 10px;
          margin: auto;
          box-shadow: 0px 2px 2px 0px rgba(154, 90, 30, 40);
          background-image: linear-gradient(to bottom, #e2daa8, #f8b015);
        }
        span {
          width: 44%;
          display: flex;
          justify-content: center;
          // flex: 1;
          height: 30px;
          letter-spacing: 4px;
          text-indent: 4px;
        }
        span {
          text-align: center;
          line-height: 30px;
          color: rgb(105, 68, 26);
          font-size: 16px;
          font-weight: bold;
          // background-color: #f0b83c;
          border-radius: 6px;
          background-size: 100% 100%;
          box-shadow: 0px 2px 2px 0px rgba(154, 90, 30, 40);
          background-image: linear-gradient(to bottom, #e2daa8, #f8b015);
        }
        span:last-child {
          background-size: 100% 100%;
        }
      }
    }
    .cm_list {
      // display: flex;
      // width: 46%;
      margin: 0 auto;
      top:0;
      left: 0;
      right: 0;
      position: absolute;
      .btns {
        // position: absolute;
        // top: 0;
        // left: 0;
        width: 54%;
        // transform: translateY(-150%);
        display: flex;
        justify-content: space-between;
        margin: 0 auto 10px;
        margin-top: 10vh;
        span {
          width: 47%;
          // flex: 1;
          height: 30px;
        }
        span {
          text-align: center;
          line-height: 30px;
          color: #fff;
          font-size: 16px;
          font-weight: bold;
          background: url(../../assets/img/others/14.png) no-repeat 0 0;
          background-size: 100% 100%;
        }
        span:last-child {
          margin-left: 20px;
        }
      }
      .cm_list_cont {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        span {
          margin: 0 2px;
          img {
            width: 5.8vh;
            height: 5.8vh;
          }
          & > img {
            display: inline-block;
            position: relative;
            z-index: 10;
          }
          .active {
            position: relative;
            top: -6px;
          }
        }
      }
      // & > span {
      //     flex: 1;
      //     padding: 0 3px;
      //     text-align: center;
      //     position: relative;
      //     img {
      //         width: 34px;
      //         heigth: 34px;
      //     }
      //     & > img {
      //         display: inline-block;
      //         position: relative;
      //         z-index: 10;
      //     }
      //     .active {
      //         position: relative;
      //         top: -6px;
      //     }
      // }
    }

    .zw_l_and_r {
      position: absolute;
      width: 12.5%;
      // height: 85%;
      top: 16.929vh;
      box-sizing: border-box;
      & > span {
        display: block;
        width: 85%;
        box-sizing: border-box;
        position: absolute;
        img {
          display: block;
          width: 100%;
          height: 100%;
          margin: auto;
        }
        // .default-img{
        //     height: 34px;
        // }
      }
      & > span:nth-child(2n) {
      }
    }
    .zw_left {
      left: 0;
      & > span {
        left: 2.129vw;
      }
    }
    .zw_right {
      //   left: auto;
      right: 0;
      & > span {
        right: 2.129vw;
      }
    }
    .zw_top {
      margin: 0 10.64vw;
      // text-align: center;
      // left: 15%;
      & > span {
        width: 8.73vw;
        height: 4.782vh;
        display: inline-block;
        margin-left: 2.22vw;
        // height: 35px;
        img {
          display: block;
          height: 100%;
          width: 100%;
          margin: auto;
        }
      }

      span:nth-child(4) {
        //margin-left: 12%;
      }
      span:nth-child(10) {
        margin-left: 12%;
      }
    }

    .zw_top_top {
      top: 16.929vh;
      position: absolute;
      left: 0;
      right: 0;
    }
    .is60 {
      top: 90px;
      span {
        width: 14%;
      }
      span:nth-child(4) {
        margin-left: 0;
      }
      span:nth-child(10) {
        margin-left: 0;
      }
    }
    .is38 {
      & > span {
        width: 8.73vw;
        height: 4.782vh;
      }
    }

    .zw_left_two {
      position: absolute;
      top: calc(28vh + 75vw);
      left: 15.5%;

      width: 9%;
      & > span {
        margin-bottom: 10px;
        display: block;
        img {
          display: block;
          width: 90%;
          margin: auto;
        }
      }
    }
    .two_right {
      left: auto;
      right: 15%;
    }
    .rz {
      position: relative;
      div {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        border-radius: 3px;
        border: 1px solid #fff;
        height: 100%;
        box-sizing: border-box;
        padding-top: 5px;
        background-color: #000;
        img {
          width: 15px;
          height: 15px;
          display: block;
          margin: auto;
          background-color: #fff;
        }
        i {
          color: #fff;
          display: block;
          font-size: 10px;
          transform: scale(0.9);
          text-align: center;
          padding-top: 1px;
          overflow: hidden;
        }
      }
    }
  }
  .fonter {
    width: 100%;
    position: fixed;
    bottom: 0;
    left: 0;
    z-index: 1000;
    box-sizing: border-box;
    display: flex;
    height: 8vh;
    background: url(../../assets/img/others/font.png) no-repeat 0 0;
    background-size: 100% 100%;
    span {
      flex: 1;
      img {
        display: block;
        width: 45px;
        margin: auto;
      }
    }
    .zb {
      img {
        width: 35px;
      }
    }
  }
}
</style>
<style lang="less">
.g_diglog {
  .main {
    top: 10%;
    background-size: 100% 100%;
  }
}
</style>
<style lang="less">
.animate {
  position: fixed;
  top: 70%;
  left: 20%;
  opacity: 0;
  z-index: 100;
  transition: all 0.5s;
  width: 25px;
}
.res_animate {
  position: fixed;
  bottom: 30%;
  width: 50%;
  left: 25%;
  z-index: 100;
  animation: resAni 2s linear 1;
}
@keyframes resAni {
  0% {
    opacity: 0;
    transform: scale(1);
  }
  30% {
    opacity: 0.3;
    transform: scale(1.03);
  }
  50% {
    opacity: 0.5;
    transform: scale(1.05);
  }
  80% {
    opacity: 0.8;
    transform: scale(1.08);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}
.leave {
  -webkit-filter: grayscale(100%);
  -moz-filter: grayscale(100%);
  -ms-filter: grayscale(100%);
  -o-filter: grayscale(100%);
  filter: grayscale(100%);
  filter: gray;
  opacity: 0.7; //通过改变透明度来调节灰色的程度
}
.user {
  text-align: center;
  position: relative;
  height: 100%;
  width: 100%;
}
.ready {
  color: orange;
  font-size: 2.037vw;
  position: absolute;
  bottom: 1px;
  left: 0;
  right: 0;
  display: inline-block;
  z-index: 101;
}
.main_content {
  position: relative;
  float: left;
  height: auto;
  width: 100%;
  margin-top: -20px;
}
.zw_float_right {
  float: right;
  margin-right: 2.222vw;
  margin-left: 0 !important;
}
.res_list_left_num {
  display: block;
  height: 3.38vh;
  margin-left: -18px;
  color: rgba(255, 255, 255, 0.5);
  float: left;
  line-height: 3.38vh;
}
.res_list_right_num {
  display: block;
  height: 3.38vh;
  float: right;
  margin-right: -18px;
  line-height: 3.38vh;
  color: rgba(255, 255, 255, 0.5);
}
.kaijiang {
  margin: 0 auto;
  width: 50%;
  display: flex;
  span {
    flex: 1;
    height: 4.87vh;
    margin-top:12.8vh
  }
  span {
    width: 22.77vw;
    background: url(../../assets/img/others/kuaikai.png) no-repeat 0 0;
    background-size: 100% 100%;
  }
  span:last-child {
    margin-left: 4.166vw;
    width: 22.77vw;
    background: url(../../assets/img/others/mankai.png) no-repeat 0 0;
    background-size: 100% 100%;
  }
}
.qiangzhuang {
  margin: 0 auto;
  width: 50%;
  display: flex;
  margin-top:12.8vh;
  span {
    flex: 1;
    height:4.87vh;
  }
  span {
    width: 22.77vw;
    background: url(../../assets/img/others/qiangzhuang.png) no-repeat 0 0;
    background-size: 100% 100%;
  }
  span:last-child {
    margin-left: 4.166vw;
    width: 22.77vw;
    background: url(../../assets/img/others/buqiangzhuang.png) no-repeat 0 0;
    background-size: 100% 100%;
  }
}
.btn-ready{
    width: 27.87vw;
    height: 4.875vh;
    margin-top:12.8vh;
    border: none;
    display: block;
    margin-left: auto;
    margin-right: auto;

    
}
.console_bottom{
  position: relative;

}
.text-tips{
  font-size: 5vw;
  color: #fff;
  text-align: center;
  width: 100%;
  height: 3.25vh;
  text-shadow:1px 1px 0px #b4a296
}

</style>
