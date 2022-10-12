<template>
  <div class="box">
    <div v-if="atype == 1">
      <p v-for="(item, index) in text"
         :key="index">
        <a :href="item.url"
           target="_blank">{{index+1}}.{{item.text}}</a>
      </p>
      <p v-show="text.length == 0">no list</p>
    </div>
    <div v-else-if="atype == 999">
      <p>Command line</p>
      <div v-for="(item, index) in cmdList"
           :key="index">
        <p>/{{ item.name }}</p>
        <div class="btr"
             v-for="(items, indexs) in item.list"
             :key="indexs + 's'">
          <div class="btd">
            <span class="active">{{ items.cmd }}</span>
            <span> {{ items.text }}</span>
          </div>
          <div class="btd">
            <span>{{ items.zhtext }}</span>
          </div>
        </div>
      </div>
      <br />
      <p>Shortcut key</p>
      <div class="btr"
           v-for="(item, index) in keyList"
           :key="index + 'a'">
        <div class="btd">
          <span> {{ item.text }}</span>
        </div>
        <div class="btd">
          <span>{{ item.zhtext }}</span>
        </div>
      </div>
    </div>
    <p v-else>{{ text }}</p>
  </div>
</template>
<script>
export default {
  props: {
    text: {
      type: [String, Array, Object],
      default: "",
    },
    atype: {
      type: Number,
      default: 0,
    },
  },
  data () {
    return {
      cmdList: [],
      keyList: [],
    };
  },
  created () {
    let data = require("../assets/json/index.json");
    this.cmdList = data.cmdList;
    this.keyList = data.keyList;
  },
};
</script>
<style lang="scss" scoped>
.box {
  a {
    color: #28bfff;
    text-decoration: none;
    position: relative;
  }
  a::after {
    position: absolute;
    left: 0;
    top: 100%;
    content: "";
    background-color: #28bfff;
    width: 100%;
    transform: scale(0);
    -webkit-transform: scale(0);
    transition: all 0.5s;
    -webkit-transition: all 0.5s;
  }
  a:hover::after {
    height: 1px;
    -webkit-transform: scale(1);
    transform: scale(1);
  }
  .btr {
    display: flex;
    align-items: flex-start;
  }
  .btd {
    display: inline-block;
    width: 40%;
    max-width: 350px;
    min-width: 150px;
  }
  .active {
    color: #28bfff;
  }
}
</style>
