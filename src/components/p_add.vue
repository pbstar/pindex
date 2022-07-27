<template>
  <div class="box">
    <span>PS C:\></span>
    <input type="text" v-model="text" @keyup.enter="submit" />
  </div>
</template>
<script>
export default {
  data() {
    return {
      text: "",
    };
  },
  methods: {
    submit() {
      this.$emit("submit", this.text);
      this.text = "";
    },
  },
};
</script>
<style lang="scss" scoped>
.box {
  display: flex;
  align-items: center;
  input {
    flex: 1;
    border: none;
    background-color: #000;
    color: #fff;
    height: 20px;
    line-height: 20px;
    margin-left: 10px;
  }
}
</style>
