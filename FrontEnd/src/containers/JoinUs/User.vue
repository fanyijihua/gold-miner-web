<template>
  <div class="container join__container">
    <el-breadcrumb class="breadcrumb">
      <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
      <el-breadcrumb-item :to="{ path: '/joinus/users' }">申请加入的用户列表</el-breadcrumb-item>
      <el-breadcrumb-item :to="{ path: `/joinus/users/${id}` }">用户</el-breadcrumb-item>
    </el-breadcrumb>
    <h1>{{ id }}</h1>
  </div>
</template>

<script>
export default {
  name: 'JoinUsUser',
  data() {
    return {
    }
  },
  computed: {
    id() {
      return this.$route.params.id
    },
  },
  created() {
    this.fetchData()
  },
  methods: {
    fetchData() {
      console.log('fetchData')
    },
  },
}
</script>

<style lang="scss" scoped>
</style>
