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
      default: 0,
    },
    typeList: {
      type: Array,
      default: function () {
        return [];
      },
    },
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
