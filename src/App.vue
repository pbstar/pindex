<template>
  <div id="app">
    <p_header />
    <div class="body">
      <div class="item" v-for="(item, index) in list" :key="index">
        <p_added :text="item.q" />
        <span>{{ item.a }}</span>
      </div>
    </div>
    <div class="loading" v-show="isloading">...</div>
    <p_add v-show="!isloading" @submit="submit" />
  </div>
</template>

<script>
import p_header from "@/components/p_header.vue";
import p_add from "@/components/p_add.vue";
import p_added from "@/components/p_added.vue";
export default {
  components: {
    p_header,
    p_add,
    p_added,
  },
  data() {
    return {
      list: [],
      isloading: false,
    };
  },
  methods: {
    submit(e) {
      if (e) {
        this.isloading = true;
        // this.list.push({
        //   q: e,
        //   a: "no",
        // });
      } else {
        this.list.push({
          q: e,
          a: "",
        });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
#app {
  height: 100%;
  background-color: #000;
  padding: 20px;
  box-sizing: border-box;
  overflow-y: auto;
  &::-webkit-scrollbar {
    width: 10px; //对垂直方向滚动条
  }
  //滚动的滑块
  &::-webkit-scrollbar-thumb {
    border-radius: 3px;
    background-color: #444//滚动条的颜色;
  }
  //内层滚动槽
  &::-webkit-scrollbar-track-piece {
    background-color: #000;
  }
}
.body {
  margin-top: 56px;
}
.loading {
  width: 0.6em;
  display: block;
  overflow: hidden;
  animation: dot 2s infinite step-end;
}
@keyframes dot {
  33% {
    width: 1.3em;
  }
  66% {
    width: 2em;
  }
}
</style>
