<template>
  <div class="join-us container">
    <el-breadcrumb class="breadcrumb">
      <el-breadcrumb-item v-for="item, index in breadcrumb" :key="index" :to="item.to">{{ item.label }}</el-breadcrumb-item>
    </el-breadcrumb>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'JoinUsBase',
  data() {
    return {
      breadcrumb: [
        {
          label: '首页',
          to: {
            path: '/',
          },
        },
        {
          label: '译者申请列表',
          to: {
            path: '/joinus/users',
          },
        },
        {
          label: '根号三',
          to: {
            path: '/joinus/users/1',
          },
        },
      ],
    }
  },
}
</script>

<style lang="scss" scoped>
</style>
