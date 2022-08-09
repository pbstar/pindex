<template>
  <div id="app">
    <p_header />
    <div class="body">
      <div :class="type == 0 && isFirst ? 'toptext1' : 'toptext2'">
        Welcome to PINDEX, please use 'help'.
      </div>
      <div class="item"
           v-for="(item, index) in list"
           :key="index">
        <p_added :text="item.q"
                 :cmd="item.cmd"
                 :type="item.type"
                 :typeList="typeList" />
        <p_answer v-show="!(isloading && index == list.length - 1)"
                  :text="item.a"
                  :type="item.atype" />
      </div>
    </div>
    <div class="loading"
         v-show="isloading">...</div>
    <p_add v-show="!isloading"
           ref="p_add"
           :type="type"
           :typeList="typeList"
           :hisList="hisList"
           @submit="submit"
           @changeType="changeType" />
  </div>
</template>

<script>
import p_header from "@/components/p_header.vue";
import p_add from "@/components/p_add.vue";
import p_added from "@/components/p_added.vue";
import p_answer from "@/components/p_answer.vue";
import { dataConversionUtil } from "@/assets/js/export";
export default {
  components: {
    p_header,
    p_add,
    p_added,
    p_answer,
  },
  data () {
    return {
      list: [],
      isloading: false,
      type: 0,
      typeList: [],
      isFirst: true,
      hisList: [],
    };
  },
  created () {
    let hislist = this.$unit.getLocalStorage("pindex_history_list");
    if (hislist && hislist != JSON.stringify(this.hisList)) {
      this.hisList = JSON.parse(hislist);
    }
    this.getTypeList()
  },
  mounted () {
    document.oncontextmenu = () => { return false };
    this.watchKey();
  },
  methods: {
    watchKey () {
      document.onkeydown = () => {
        var e = window.event || arguments[0];
        if (e.keyCode == 123) {
          alert("不许搞我哦!");
        } else if (e.ctrlKey && e.keyCode == 85) {
          return false;
        } else if (e.ctrlKey && e.keyCode == 83) {
          return false;
        } else if (e.ctrlKey && e.keyCode == 67) {
          if (this.list.length > 0 && this.isloading) {
            this.list[this.list.length - 1].a = "break off";
            this.isloading = false;
            this.$refs.p_add.tofocus();
          }
        } else if (e.ctrlKey && e.keyCode == 76) {
          this.isloading = false;
          this.list = [];
        } else if (e.keyCode == 8) {
          this.$refs.p_add.todel();
        } else if (e.keyCode == 38 || e.keyCode == 40) {
          this.getHisList(e.keyCode);
        }
      };
    },
    getTypeList () {
      let clist = require("./assets/json/index.json").cmdList;
      for (let i = 0; i < clist.length; i++) {
        if (clist[i].type > 0) {
          this.typeList.push({
            text: clist[i].name,
            type: clist[i].type
          })
        }
      }
    },
    getHisList (code) {
      let hislist = this.$unit.getLocalStorage("pindex_history_list");
      if (hislist && hislist != JSON.stringify(this.hisList)) {
        this.hisList = JSON.parse(hislist);
      }
      this.$refs.p_add.toUpDown(code);
    },
    submit (e) {
      if (this.$unit.isMobile()) {
        this.toMobile(e);
      } else {
        if (e.text || e.cmd) {
          this.toSetHistory(e);
          this.isloading = true;
          this.toType(e);
        } else {
          this.toNoAns(e);
        }
      }
    },
    toType (e) {
      if (this.type == 0) {
        if (e.cmd) {
          if (e.cmd == "cd") {
            if (e.text.indexOf("&nbsp;") > -1 && e.text.length > 6) {
              let boo = true;
              for (let i = 0; i < this.typeList.length; i++) {
                if (this.typeList[i].text == e.text.slice(6)) {
                  boo = false;
                  this.isFirst = false;
                  this.toNoAns(e);
                  this.type = this.typeList[i].type;
                  this.isloading = false;
                }
              }
              if (boo) this.toNofind(e);
            } else {
              this.toNofind(e);
            }
          } else if (e.cmd == "help") {
            this.list.push({
              q: e.text,
              cmd: e.cmd,
              type: this.type,
              a: "",
              atype: 999,
            });
            this.isloading = false;
          }
        } else {
          this.toNofind(e);
        }
      } else if (this.type == 1) {
        if (e.cmd) {
          if (e.cmd == "cd..") {
            this.toType0(e);
          }
        } else {
          this.toNoAns(e);
          let sign = this.$unit.toMd5(
            "20220728001285904" + e.text + "pindex" + "ybpkoC_rhQ3fRABGkhXx"
          );
          this.$http
            .get("api/fanyi.php", {
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
                  if (res.data.text) {
                    this.list[this.list.length - 1].a = res.data.text;
                    this.isloading = false;
                  } else {
                    this.toNofind(e);
                  }
                }
              } else {
                if (this.list.length > 0 && this.isloading) {
                  this.list[this.list.length - 1].a = "no find";
                  this.isloading = false;
                }
              }
              this.$refs.p_add.tofocus();
            });
        }
      } else if (this.type == 2) {
        if (e.cmd) {
          if (e.cmd == "cd..") {
            this.toType0(e);
          } else if (e.cmd == "list") {
            let list = [];
            if (this.$unit.getLocalStorage("pindex_collect_list")) {
              list = JSON.parse(
                this.$unit.getLocalStorage("pindex_collect_list")
              );
            }
            this.list.push({
              q: e.text,
              cmd: e.cmd,
              type: this.type,
              a: list,
              atype: 1,
            });
            this.isloading = false;
          } else if (
            (e.cmd == "add" || e.cmd == "del") &&
            e.text.indexOf("&nbsp;") > -1 &&
            e.text.length > 6
          ) {
            let strList = e.text
              .slice(6)
              .replace(/\s+/g, "&nbsp;")
              .split("&nbsp;");
            let list = [];
            if (this.$unit.getLocalStorage("pindex_collect_list")) {
              list = JSON.parse(
                this.$unit.getLocalStorage("pindex_collect_list")
              );
            }
            let index = -1;
            for (let i = 0; i < list.length; i++) {
              if (list[i].text == strList[0]) index = i;
            }
            if (e.cmd == "add") {
              if (strList.length > 1) {
                var reg =
                  /^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/)(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/; // eslint-disable-line
                if (reg.test(strList[1])) {
                  if (index >= 0) {
                    list[index].url = strList[1];
                  } else {
                    list.push({
                      text: strList[0],
                      url: strList[1],
                    });
                  }
                  this.$unit.setLocalStorage(
                    "pindex_collect_list",
                    JSON.stringify(list)
                  );
                  this.toSuccess(e);
                } else {
                  this.toError(e);
                }
              } else {
                this.toError(e);
              }
            } else if (e.cmd == "del") {
              if (index >= 0) {
                list.splice(index, 1);
                this.$unit.setLocalStorage(
                  "pindex_collect_list",
                  JSON.stringify(list)
                );
                this.toSuccess(e);
              } else {
                this.toError(e);
              }
            }
          } else if (e.cmd == "export") {
            let list = [];
            if (this.$unit.getLocalStorage("pindex_collect_list")) {
              list = JSON.parse(
                this.$unit.getLocalStorage("pindex_collect_list")
              );
            }
            var tableHeader = [["序号", "名称", "网址"]];
            var dataList = [];
            list.forEach((item, index) => {
              dataList.push([index + 1, item.text, item.url]);
            });
            dataConversionUtil.dataToExcel(
              "Pindex收藏列表",
              tableHeader,
              dataList
            );
            this.toSuccess(e);
          }
        } else {
          this.toNofind(e);
        }
      } else if (this.type == 3) {
        if (e.cmd) {
          if (e.cmd == "cd..") {
            this.toType0(e);
          } else if (e.cmd == "baidu") {
            this.toSearch(e, 1);
          } else if (e.cmd == "csdn") {
            this.toSearch(e, 2);
          }
        } else {
          this.toSearch(e, 0);
        }
      } else if (this.type == 4) {
        if (e.cmd) {
          if (e.cmd == "cd..") {
            this.toType0(e);
          } else if (e.cmd == "weibo" || e.cmd == "baidu" || e.cmd == "zhihu") {
            this.toGetResou(e);
          }
        } else {
          this.toNofind(e);
        }
      }
    },
    toType0 (e) {
      this.toNoAns(e);
      this.type = 0;
      this.isloading = false;
    },
    toNoAns (e) {
      this.list.push({
        q: e.text,
        cmd: e.cmd,
        type: this.type,
        a: "",
        atype: 0,
      });
    },
    toNofind (e) {
      this.list.push({
        q: e.text,
        cmd: e.cmd,
        type: this.type,
        a: "not find",
        atype: 0,
      });
      this.isloading = false;
    },
    toSuccess (e) {
      this.list.push({
        q: e.text,
        cmd: e.cmd,
        type: this.type,
        a: "success",
        atype: 0,
      });
      this.isloading = false;
    },
    toError (e) {
      this.list.push({
        q: e.text,
        cmd: e.cmd,
        type: this.type,
        a: "error",
        atype: 0,
      });
      this.isloading = false;
    },
    toMobile (e) {
      this.list.push({
        q: e.text,
        cmd: e.cmd,
        type: this.type,
        a: "Please use it on pc!",
        atype: 0,
      });
      this.isloading = false;
    },
    toSetHistory (e) {
      let hislist = this.$unit.getLocalStorage("pindex_history_list");
      if (hislist) this.hisList = JSON.parse(hislist);
      if (this.hisList.length > 19) this.hisList.pop();
      this.hisList.unshift({
        cmd: e.cmd,
        text: e.text,
        type: this.type,
      });
      this.$unit.setLocalStorage(
        "pindex_history_list",
        JSON.stringify(this.hisList)
      );
    },
    changeType (e) {
      this.type = e;
    },
    toSearch (e, type) {
      this.toSuccess(e);
      if (type > 0) e.text = e.text.slice(6);
      let baseUrl = "https://www.baidu.com/s?wd=";
      if (type == 2) baseUrl = "https://so.csdn.net/so/search?q=";
      window.open(baseUrl + e.text, "_blank");
    },
    toGetResou (e) {
      this.toNoAns(e);
      this.$http
        .get("api/get_resou.php", {
          name: e.cmd
        })
        .then((res) => {
          if (res.code == 200) {
            if (this.list.length > 0 && this.isloading) {
              if (res.data.length > 0) {
                this.list[this.list.length - 1].atype = 1
                let list = []
                for (let i = 0; i < res.data.length; i++) {
                  list.push({
                    text: res.data[i].keyword,
                    url: res.data[i].url
                  })
                }
                this.list[this.list.length - 1].a = list;
                this.isloading = false;
              } else {
                this.toNofind(e);
              }
            }
          } else {
            if (this.list.length > 0 && this.isloading) {
              this.list[this.list.length - 1].a = "no find";
              this.isloading = false;
            }
          }
          this.$refs.p_add.tofocus();
        });
    }
  },
};
</script>
<style scoped>
@import "./assets/css/app.scss";
</style>
