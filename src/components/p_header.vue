<template>
  <div class="box">
    <div class="left">
      <span>PINDEX</span>
    </div>
    <div class="right">
      <span>X</span>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.box {
  position: fixed;
  top: 0px;
  left: 0px;
  right: 0px;
  padding: 20px 20px 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
  background-color: #000;
  .left {
    border-bottom: 1px solid #eee;
    line-height: 35px;
  }
}
</style>
