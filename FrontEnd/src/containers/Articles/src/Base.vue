<template>
  <div class="articles container">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'ArticlesBase',
}
</script>

<style lang="scss" scoped>
.articles {
  margin-top: 40px;
}
</style>
