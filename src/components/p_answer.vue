<template>
  <div class="box">
    <div v-if="type == 1">
      <p v-for="(item, index) in text" :key="index">
        <a :href="item.url" target="_blank">{{ item.text }}</a>
      </p>
      <p v-show="text.length == 0">no list</p>
    </div>
    <div v-else-if="type == 999">
      <p>Command line</p>
      <div v-for="(item, index) in cmdList" :key="index">
        <p>/{{ item.name }}</p>
        <div
          class="btr"
          v-for="(items, indexs) in item.list"
          :key="indexs + 's'"
        >
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
      <div class="btr" v-for="(item, index) in keyList" :key="index + 'a'">
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
    type: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      cmdList: [
        {
          name: "",
          list: [
            {
              cmd: "help",
              text: "",
              zhtext: "帮助",
            },
            {
              cmd: "cd",
              text: "xx",
              zhtext: "进入XX项目页",
            },
          ],
        },
        {
          name: "fanyi",
          list: [
            {
              cmd: "",
              text: "xx",
              zhtext: "将xx翻译为英文",
            },
            {
              cmd: "cd..",
              text: "",
              zhtext: "进入根项目页",
            },
          ],
        },
        {
          name: "shoucang",
          list: [
            {
              cmd: "list",
              text: "",
              zhtext: "获取收藏列表",
            },
            {
              cmd: "add",
              text: "xxname xxurl",
              zhtext: "将xxurl以xxname名称加入收藏列表",
            },
            {
              cmd: "del",
              text: "xxname",
              zhtext: "将xxname移除收藏列表",
            },
            {
              cmd: "cd..",
              text: "",
              zhtext: "进入根项目页",
            },
          ],
        },
      ],
      keyList: [
        {
          text: "ctrl+c",
          zhtext: "终结当前运行中的命令",
        },
        {
          text: "ctrl+l",
          zhtext: "清屏",
        },
      ],
    };
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
