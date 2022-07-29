<template>
  <div class="box">
    <div v-if="type == 1">
      <p v-for="(item, index) in text" :key="index">
        <a :href="item.url" target="_blank">{{ item.text }}</a>
      </p>
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
}
</style>
