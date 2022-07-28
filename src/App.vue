<template>
  <div id="app">
    <p_header />
    <div class="body">
      <div class="item" v-for="(item, index) in list" :key="index">
        <p_added :text="item.q" :cmd="item.cmd" :type="item.type" />
        <span v-show="!(isloading && index == list.length - 1)">{{
          item.a
        }}</span>
      </div>
    </div>
    <div class="loading" v-show="isloading">...</div>
    <p_add v-show="!isloading" ref="p_add" :type="type" @submit="submit" />
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
      type: 0,
    };
  },
  mounted() {
    document.oncontextmenu = () => {
      return false;
    };
    this.watchKey();
  },
  methods: {
    watchKey() {
      document.onkeydown = () => {
        var e = window.event || arguments[0];
        if (e.keyCode == 123) {
          return false;
        } else if (e.ctrlKey && e.keyCode == 85) {
          return false;
        } else if (e.ctrlKey && e.keyCode == 83) {
          return false;
        } else if (e.ctrlKey && e.keyCode == 67) {
          if (this.list.length > 0 && this.isloading) {
            this.list[this.list.length - 1].a = "中断";
            this.isloading = false;
            this.$refs.p_add.tofocus();
          }
        } else if (e.ctrlKey && e.keyCode == 76) {
          this.isloading = false;
          this.list = [];
        } else if (e.keyCode == 8) {
          this.$refs.p_add.todel();
        }
      };
    },
    submit(e) {
      if (e.text || e.cmd) {
        this.isloading = true;
        if (this.type == 0) {
          this.toType0(e);
        } else {
          if (this.type == 1) {
            this.toType1(e);
          }
        }
      } else {
        this.list.push({
          q: e.text,
          cmd: e.cmd,
          type: this.type,
          a: "",
        });
      }
    },
    toType0(e) {
      if (e.cmd) {
        if (e.cmd == "cd") {
          if (e.text == "&nbsp;fanyi") {
            this.list.push({
              q: e.text,
              cmd: e.cmd,
              type: this.type,
              a: "",
            });
            this.type = 1;
          } else {
            this.list.push({
              q: e.text,
              cmd: e.cmd,
              type: this.type,
              a: "no fond",
            });
          }
          this.isloading = false;
        }
      } else {
        this.list.push({
          q: e.text,
          cmd: e.cmd,
          type: this.type,
          a: "",
        });
      }
    },
    toType1(e) {
      if (e.cmd) {
        if (e.cmd == "cd..") {
          this.list.push({
            q: e.text,
            cmd: e.cmd,
            type: this.type,
            a: "",
          });
          this.type = 0;
          this.isloading = false;
        }
      } else {
        this.list.push({
          q: e.text,
          cmd: e.cmd,
          type: this.type,
          a: "",
        });
        let sign = this.$unit.toMd5(
          "20220728001285904" + e.text + "pindex" + "ybpkoC_rhQ3fRABGkhXx"
        );
        this.$http
          .get("http://pindexapi.mcweb.club/api/fanyi.php", {
            text: e.text,
            from: "zh",
            to: "en",
            appid: "20220728001285904",
            salt: "pindex",
            sign: sign,
          })
          .then((res) => {
            if (res.code == 200) {
              if (this.list.length > 0 && this.isloading) {
                this.list[this.list.length - 1].a = res.data.text;
                this.isloading = false;
              }
            } else {
              if (this.list.length > 0 && this.isloading) {
                this.list[this.list.length - 1].a = "no fond";
                this.isloading = false;
              }
            }
            this.$refs.p_add.tofocus();
          });
      }
    },
  },
};
</script>
<style scoped>
@import "./assets/css/app.scss";
</style>
