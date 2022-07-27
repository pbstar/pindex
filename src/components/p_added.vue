<template>
  <div class="box">
    <span>PS C:\></span>
    <span style="margin-left: 10px">{{ text }}</span>
  </div>
</template>
<script>
export default {
  props: {
    text: {
      type: String,
      default: "",
    },
  },
};
</script>
<style lang="scss" scoped>
.box {
  display: flex;
  align-items: center;
}
</style>
