<template>
  <div class="auth container">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'AuthBase',
}
</script>

<style lang="scss" scoped>
.auth {
  min-height: 300px;
}
</style>
