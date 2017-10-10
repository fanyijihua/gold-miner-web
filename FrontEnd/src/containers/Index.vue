<template>
  <div class="container">
    <el-row class="main grid__row-gutter">
      <el-col class="grid__col-gutter" :span="18">
        <el-tabs v-model="activeTab" v-loading="loading" @tab-click="toggleTab">
          <el-tab-pane v-for="tab in articlesTab" :label="tab.label" :name="tab.name" :key="tab.name">
            <article-item v-for="item in articles[tab.name]" :article="articles.data[item]" :key="item"></article-item>
            <div class="text-center no-content" v-if="noContent">
              <router-link to="/recommends/new">没有找到喜欢的文章？不如给我们推荐几篇吧~</router-link>
            </div>
            <div class="text-center load-more" v-if="showMoreBtn">
              <a class="load-more__btn" href="javascript:;" @click="nextPage()">{{ showMoreBtnLoading ? '加载中...' : '浏览更多'}}</a>
              <div class="line"></div>
            </div>
          </el-tab-pane>
        </el-tabs>
      </el-col>
      <el-col class="grid__col-gutter" :span="6">
        <div class="card">
          <h3 class="card__title">{{ currentUser.translator ?  '推荐文章' : '加入我们' }}</h3>
          <div><router-link :to="currentUser.translator ?  '/recommends/new' : '/applications/apply'"><img class="img-rounded" src="/static/images/join.jpg" alt=""></router-link></div>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'

const articlesTab = [
  {
    name: 'posted',
    label: '最新译文',
  },
  {
    name: 'awaiting',
    label: '等待认领',
  },
  {
    name: 'progressing',
    label: '正在进行',
  },
]

export default {
  name: 'Index',
  data() {
    return {
      articlesTab,
      loading: false,
      activeTab: this.$store.getters.currentUser.translator ? 'awaiting' : 'posted',
      page: 1,
      noContent: false,
      showMoreBtn: false,
      showMoreBtnLoading: false,
    }
  },
  computed: {
    ...mapState(['articles']),
    ...mapGetters(['currentUser']),
  },
  beforeRouteLeave(to, from, next) {
    next()
  },
  methods: {
    ...mapActions(['fetchArticles']),

    toggleTab() {
      this.page = 1
      this.noContent = false
      this.showMoreBtn = false

      this.renderArticles()
    },

    nextPage() {
      this.page += 1

      this.showMoreBtnLoading = true

      this.renderArticles().then(() => {
        this.showMoreBtnLoading = false
      })
    },

    renderArticles() {
      const perpage = 10

      return this.fetchArticles({
        type: this.activeTab,
        page: this.page,
        perpage,
      }).then((data) => {
        if (data.length === 0) {
          if (this.page === 1) {
            this.noContent = true
          } else {
            this.$message.warning('已经到底啦~')
          }
        } else if (data.length < perpage) {
          this.showMoreBtn = false
        } else {
          this.showMoreBtn = true
        }

        return Promise.resolve(data)
      }).catch((err) => {
        this.$message.error(err.message)

        return Promise.reject(err)
      })
    },
  },
  created() {
    this.loading = true

    this.renderArticles().then(() => {
      this.loading = false
    }).catch(() => {
      this.loading = false
    })
  },
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

.main {
  margin-top: $grid-gutter-width * 1.5;
}
.grid__row-gutter {
  margin-left: floor(-$grid-gutter-width / 2);
  margin-right: ceil(-$grid-gutter-width / 2);
}
.grid__col-gutter {
  padding-left: floor($grid-gutter-width / 2);
  padding-right: ceil($grid-gutter-width / 2);
}

.load-more {
  height: 60px;
  margin: 60px 0;
}

.load-more__btn {
  display: inline-block;
  padding: 10px 50px;
  font-size: 14px;
  border: 1px solid $primary;
  border-radius: 4px;
  color: $primary;
}
.load-more__btn:hover {
  color: #fff;
  background-color: $primary;
}

.no-content {
  a {
    display: block;
    margin: 100px 0;
    font-size: 16px;
    color: $blue;
  }
}

.card {
  img {
    width: 100%;
    height: 200px;
  }
}
</style>
