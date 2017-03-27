<template>
  <el-tabs v-model="active" @tab-click="handleClick">
    <el-tab-pane v-for="tab in tabs" :label="tab.label" :name="tab.name" :key="tab.name">
      <article-item v-for="item in tab.data" :article="item" :key="item"></article-item>
      <div class="text-center load-more">
        <a href="javascript:;">查看更多</a>
        <div class="line"></div>
      </div>
    </el-tab-pane>
  </el-tabs>
</template>
<script>
import ArticleItem from './Item'

const mockArticle = {
  id: '1',
  title: '如何为复杂应用设计表单',
  description: '从复杂的 ERP（Enterprise Resource Planning，企业资源计划）系统到 Facebook，是数据的输入让应用们有了意义。表单在许多时候是用户提交数据的一个必经入口。本文介绍了呈现表单的 13 种不同的方法，并探讨了数据输入的未来。总之是很屌的一篇文章。',
  category: '设计',
  author: {
    id: '1',
    username: '根号三',
    avatar: '/static/avatar.png',
  },
  meta: {
    createdAt: '28 分钟前',
  },
}

const tabs = [
  {
    name: 'lastest',
    label: '最新译文',
    data: [mockArticle, mockArticle, mockArticle, mockArticle, mockArticle],
  },
  {
    name: 'waiting',
    label: '等待认领',
    data: [mockArticle],
  },
  {
    name: 'doing',
    label: '正在进行',
    data: [],
  },
]

export default {
  name: 'Articles',
  components: {
    'article-item': ArticleItem,
  },
  data() {
    return {
      tabs,
    }
  },
  computed: {
    active() {
      return this.$store.state.user.logIn ? 'waiting' : 'lastest'
    },
  },
  methods: {
    handleClick(tab) {
      // eslint-disable-next-line
      console.log(tab.index, tab.name)
    },
  },
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

.load-more {
  height: 60px;
  margin: 60px 0;

  .line {
    margin-top: -30px;
    height: 1px;
    background-color: $silver-extra-light;
  }

  a {
    display: inline-block;
    height: 60px;
    line-height: 60px;
    padding: 0 20px;
    font-size: 14px;
    background-color: #fff;
    color: $silver-extra-light;
  }
}
</style>
