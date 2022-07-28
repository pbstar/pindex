<template>
  <div class="box">
    <div class="label">
      <span>PS C:\</span>
      <span v-show="type==1">fanyi\</span>
      <span style="margin-right: 6px;">></span>
      <span class="active">{{cmd}}</span>
    </div>
    <div v-html="text"></div>
  </div>
</template>
<script>
export default {
  props: {
    text: {
      type: String,
      default: "",
    },
    cmd: {
      type: String,
      default: "",
    },
    type: {
      type: Number,
      default: 0
    }
  },
};
</script>
<style lang="scss" scoped>
.box {
  display: flex;
  align-items: center;
  .label {
    float: left;
    .active {
      color: #28bfff;
    }
  }
}
</style>
