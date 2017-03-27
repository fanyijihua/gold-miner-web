<template>
  <div class="container admin">
    <el-row>
      <el-col :span="5">
        <el-menu class="admin__nav" :default-openeds="['tasks']" :router="true">
          <el-submenu index="tasks">
            <template slot="title">任务申请</template>
            <el-menu-item index="1-1">翻译认领</el-menu-item>
            <el-menu-item index="1-2">校对认领</el-menu-item>
          </el-submenu>
          <el-menu-item index="texts" :route="{ path: '/admin/texts' }">试译文本管理</el-menu-item>
        </el-menu>
      </el-col>
      <el-col class="admin__content" :span="19">
        <router-view></router-view>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  name: '',
  data() {
    return {
    }
  },
  methods: {
  },
}
</script>

<style lang="scss" scoped>
.admin {
  min-height: 400px;
  margin-top: 30px;

  &__nav {
    min-height: 400px;
  }

  &__content {
    padding: 0 20px;
  }
}
</style>
