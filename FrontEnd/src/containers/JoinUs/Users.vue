<template>
  <div class="container join__container">
    <el-breadcrumb class="breadcrumb">
      <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
      <el-breadcrumb-item :to="{ path: '/joinus/users' }">申请加入的用户列表</el-breadcrumb-item>
    </el-breadcrumb>
    <ul>
      <li v-for="i in 10">
        <router-link :to="`/joinus/users/${i}`">{{ i }}</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'JoinUsUsers',
  data() {
    return {
    }
  },
  methods: {
  },
}
</script>

<style lang="scss" scoped>
</style>
