<template>
  <div class="">
    <h1>文章列表</h1>
    <ul>
      <li v-for="i in 10">
        <router-link :to="`/articles/${i}`">{{ i }}</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'ArticleList',
}
</script>

<style lang="scss" scoped>
</style>
