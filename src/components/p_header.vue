<template>
  <div class="box">
    <div class="left">
      <span>PINDEX</span>
    </div>
    <div class="right">
      <a href="https://github.com/pbstar/pindex"
         target="_blank">
        <img src="../assets/icons/github.png"
             alt="" />
      </a>
    </div>
    <div class="time">{{ time }}</div>
  </div>
</template>
<script>
export default {
  data () {
    return {
      time: "...",
      timer: "",
    };
  },
  created () {
    this.timer = setInterval(() => {
      this.getNowTime();
    }, 1000);
  },
  beforeDestroy () {
    clearInterval(this.timer);
  },
  methods: {
    getNowTime () {
      function addZero (s) {
        return s < 10 ? "0" + s : s;
      }
      var date = new Date();
      var year = date.getFullYear();
      var month = date.getMonth() + 1;
      var day = date.getDate();
      var hour = date.getHours();
      var minute = date.getMinutes();
      var second = date.getSeconds();
      this.time =
        year +
        "-" +
        addZero(month) +
        "-" +
        addZero(day) +
        " " +
        addZero(hour) +
        ":" +
        addZero(minute) +
        ":" +
        addZero(second);
    },
  },
};
</script>
<style lang="scss" scoped>
.box {
  position: fixed;
  top: 0px;
  left: 0px;
  right: 0px;
  padding: 20px 20px 7px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 3px;
  background-color: #111;
  z-index: 100;
  .left {
    border-bottom: 1px solid #eee;
    line-height: 35px;
  }
  .right {
    display: flex;
    align-items: center;
  }
  .time {
    position: absolute;
    top: 70px;
    right: 20px;
    color: #666;
  }
}
</style>
