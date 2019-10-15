<template>
  <div id="web">
    <router-view :key="$route.path + $route.query.id"></router-view>
  </div>
</template>
<script>
export default {
  name: 'App'
};
</script>
<style>
html,
body {
  width: 100%;
  height: 100%;
}
</style>

<style lang="less" scoped>
#web {
  width: 100%;
  height: 100%;
}
</style>