<template>
  <div class="box">
    <div class="label">
      <span>PS C:\</span>
      <span
        v-for="(item, index) in typeList"
        :key="index"
        v-show="type == item.type"
        >{{ item.text }}\</span
      >
      <span style="margin-right: 6px">></span>
      <span class="active">{{ cmd }}</span>
    </div>
    <div
      class="input"
      :class="isFocus ? 'inputActive' : ''"
      ref="input"
      contenteditable="true"
      @compositionstart="isInput = true"
      @compositionend="isInput = false"
      @keydown.enter.exact="submit"
      @input="change"
      @focus="isFocus = true"
      @blur="isFocus = false"
    ></div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      isFocus: false,
      list: [],
      cmd: "",
      isInput: false,
    };
  },
  props: {
    type: {
      type: Number,
      default: 0,
    },
    typeList: {
      type: Array,
      default: function () {
        return [];
      },
    },
  },
  watch: {
    type: {
      handler() {
        this.getCmdList();
      },
      deep: true,
    },
  },
  created() {
    this.getCmdList();
  },
  methods: {
    getCmdList() {
      this.$http
        .get("system/get_cmd_list.php", {
          type: this.type,
        })
        .then((res) => {
          if (res.code == 200) {
            this.list = res.data;
          }
        });
    },
    submit(e) {
      if (window.event) {
        window.event.returnValue = false;
      } else {
        e.preventDefault();
      }
      this.$emit("submit", {
        cmd: this.cmd,
        text: this.$refs.input.innerHTML.replace(/<[^>]+>/g, ""),
      });
      this.cmd = "";
      this.$refs.input.innerHTML = "";
    },
    change() {
      setTimeout(() => {
        if (this.isInput) return;
        this.$refs.input.focus();
        document.execCommand("selectAll", false, null);
        document.getSelection().collapseToEnd();
        let str = this.cmd + this.$refs.input.innerHTML.replace(/<[^>]+>/g, "");
        for (let i = 0; i < this.list.length; i++) {
          if (this.list[i].indexOf(str) >= 0) {
            this.cmd = str;
            this.$refs.input.innerHTML = "";
            return;
          }
        }
        if (this.cmd && this.$refs.input.innerHTML.indexOf("&nbsp;") < 0) {
          this.cmd = "";
          this.$refs.input.innerHTML = str;
        }
      }, 5);
    },
    todel() {
      if (this.$refs.input.innerHTML.replace(/<[^>]+>/g, "") == "") {
        this.cmd = "";
      }
    },
    tofocus() {
      this.$nextTick(() => {
        this.$refs.input.focus();
      });
    },
  },
};
</script>
<style lang="scss" scoped>
.box {
  flex: 1;
  .label {
    float: left;
    .active {
      color: #28bfff;
    }
  }
  .input {
    width: 100%;
    height: 100%;
    outline: none;
    color: transparent;
    text-shadow: 0 0 0 #fff;
  }
  .inputActive {
    &::after {
      content: "_";
      animation: dot 1s infinite step-end;
    }
  }
}
@keyframes dot {
  50% {
    color: #000;
  }
  100% {
    color: #fff;
  }
}
</style>
