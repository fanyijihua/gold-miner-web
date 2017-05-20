<template>
  <div class="container applicants">
    <div class="el-tabs">
      <div class="el-tabs__header">
        <div class="el-tabs__nav-wrap">
          <div class="el-tabs__nav">
            <div class="el-tabs__active-bar" style="width: 88px; transform: translateX(0px);"></div>
            <router-link class="el-tabs__item is-active" :to="'/applications/applicants'">译者申请</router-link>
            <router-link class="el-tabs__item" :to="'/applications/texts'">试译文本</router-link>
          </div>
        </div>
      </div>
    </div>
    <el-table :data="users" border>
      <el-table-column prop="date" label="申请日期"></el-table-column>
      <el-table-column prop="skills" label="擅长领域"></el-table-column>
      <el-table-column prop="ability" label="英语能力"></el-table-column>
      <el-table-column label="详情">
        <template scope="scope">
          <el-button type="text" size="small"><router-link :to="`/applications/applicants/${scope.row.id}`">查看</router-link></el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
const mock = [{
  id: 1,
  skills: '前端',
  ability: '过了 4 级',
  date: '2016-05-02',
}, {
  id: 2,
  skills: '后端',
  ability: '我只过了 4 集',
  date: '2016-05-02',
}, {
  id: 3,
  skills: '设计',
  ability: '过了 6 级',
  date: '2016-05-02',
}, {
  id: 4,
  skills: '前端',
  ability: '过了 8 级',
  date: '2016-05-02',
}]

export default {
  name: 'ApplicationUsers',
  data() {
    return {
      users: mock,
    }
  },
  methods: {
  },
}
</script>

<style lang="scss" scoped>
.applicants {
  margin-top: 10px;
}
</style>
