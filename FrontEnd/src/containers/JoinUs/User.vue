<template>
  <div class="container joinus">
    <!-- <el-breadcrumb class="breadcrumb">
      <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
      <el-breadcrumb-item :to="{ path: '/joinus/users' }">申请加入的用户列表</el-breadcrumb-item>
      <el-breadcrumb-item :to="{ path: `/joinus/users/${id}` }">用户</el-breadcrumb-item>
    </el-breadcrumb> -->
    <card title="申请成为译者">
      <section class="section">
        <h4 class="section__title">申请人信息</h4>
        <ul class="information clearfix">
          <li class="information__item"><span class="information__label">申请时间：</span><strong class="information__value">2017-03-26</strong></li>
          <li class="information__item"><span class="information__label">擅长的领域：</span><strong class="information__value">前端</strong></li>
          <li class="information__item"><span class="information__label">翻译经验：</span><strong class="information__value">英语 8 级</strong></li>
        </ul>
      </section>
      <hr>
      <section class="section">
        <h4 class="section__title">试译文本</h4>
        <p class="text">The push for SVG icons over font icons has caught serious momentum in the web community. With an SVG icon system you can better meet accessibility standards, render higher quality visuals, and add/remove/modify icons in the library with ease. At Pivotal we’ve created an SVG icon system with React for use on our suite of products. This article is about my approach to styling the SVG icon system with CSS to make it easy and effective to use.The push for SVG icons over font icons has caught serious momentum in the web community. With an SVG icon system you can better meet accessibility standards.</p>
      </section>
      <section class="section">
        <h4>译文</h4>
        <p class="text">可将导航栏固定在左侧，提高导航可见性，方便页面之间切换；顶部可放置常用工具，如搜索条、帮助按钮、通知按钮等。适用于中后台的管理型、工具型网站。</p>
      </section>
      <section class="section">
        <h4 class="section__title">审核意见</h4>
        <el-table class="opinions" v-if="opinions.length" :data="opinions" border>
          <el-table-column prop="result" label="审核结果">
            <template scope="scope">
              <el-tag v-if="scope.row.result" type="success">通过</el-tag>
              <el-tag v-else type="danger">拒绝</el-tag>
            </template>
          </el-table-column>
          <el-table-column prop="date" label="审核日期"></el-table-column>
          <el-table-column prop="username" label="审核人"></el-table-column>
          <el-table-column prop="opinion" label="审核意见"></el-table-column>
        </el-table>
        <div class="opinion-box">
          <el-input class="opinion" type="textarea" v-model="opinion" :rows="4"></el-input>
          <el-button>通过</el-button>
          <el-button>拒绝</el-button>
        </div>
        </el-form>
      </section>
    </card>
  </div>
</template>

<script>
const mock = [
  {
    username: '王小虎',
    opinion: '瞎胡点的',
    result: true,
    date: '2016-05-02',
  },
  {
    username: '王小鹿',
    opinion: '我也是瞎胡点的',
    result: false,
    date: '2016-05-02',
  },
]

export default {
  name: 'JoinUsUser',
  data() {
    return {
      opinions: mock,
      opinion: '',
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
@import "~styles/exports";

.joinus {
  margin-top: 30px;
}
.information {
  padding-left: 0;
  margin: 0;
  list-style: none;

  &__item {
    float: left;
    width: 33.33%;
    margin-bottom: 12px;
    font-size: 14px;
    text-indent: 10px;

    a {
      color: $primary;
    }
  }

  &__value {
    font-weight: 400;
  }
}

hr {
  border: 0;
  border-bottom:1px solid $gray-light;
}

.section {
  margin-bottom: 30px;

  .text {
    padding: 14px;
    border: 1px solid $gray;
    border-radius: 4px;
    line-height: 24px;
    font-size: 14px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  }
}

.opinions {
  margin-bottom: 30px;
}

.opinion {
  margin-bottom: 20px;
}
</style>
