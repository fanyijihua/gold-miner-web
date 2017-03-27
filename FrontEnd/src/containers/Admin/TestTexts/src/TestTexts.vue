<template>
  <div class="texts">
    <el-button class="pull-right" type="primary">添加文本</el-button>
    <div class="texts__list">
      <el-table :data="tableData" border>
        <el-table-column prop="title" label="标题"></el-table-column>
        <el-table-column prop="category" label="分类"></el-table-column>
        <el-table-column prop="date" label="创建日期"></el-table-column>
        <el-table-column prop="rate" label="通过率"></el-table-column>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="small">查看</el-button>
            <el-button type="text" size="small">编辑</el-button>
            <el-button type="text" size="small">删除</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>

<script>
const mock = [
  {
    title: '标题 1',
    date: '2016-05-02',
    category: '前端',
    rate: 0.2,
  },
  {
    title: '标题 2',
    date: '2016-05-02',
    category: '前端',
    rate: 0.2,
  },
  {
    title: '标题 3',
    date: '2016-05-02',
    category: '前端',
    rate: 0.2,
  },
  {
    title: '标题 4',
    date: '2016-05-02',
    category: '前端',
    rate: 0.2,
  },
]
export default {
  name: 'TestTexts',
  data() {
    return {
      tableData: mock,
    }
  },
  methods: {
  },
}
</script>

<style lang="scss" scoped>
.texts {
  &__list {
    padding-top: 14px;
    clear: both;
  }
}
</style>
