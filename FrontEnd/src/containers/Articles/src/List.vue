<template>
  <div class="archive">
    <div class="dashboard__box">
      <ul class="dashboard clearfix">
        <li class="dashboard__item dashboard__item--blue">
          <div class="dashboard__body">
            <i class="dashboard__icon el-icon-document"></i>
            <span class="dashboard__title">全站总翻译词汇量</span>
            <strong class="dashboard__number">{{ overview.words }}</strong>
          </div>
        </li>
        <li class="dashboard__item dashboard__item--green">
          <div class="dashboard__body">
            <i class="dashboard__icon el-icon-information"></i>
            <span class="dashboard__title">共产出优质译文</span>
            <strong class="dashboard__number">{{ overview.articles }}</strong>
          </div>
        </li>
        <li class="dashboard__item dashboard__item--gray">
          <div class="dashboard__body">
            <i class="dashboard__icon el-icon-menu"></i>
            <span class="dashboard__title">参与贡献的优秀译者</span>
            <strong class="dashboard__number">{{ overview.translators }}</strong>
          </div>
        </li>
      </ul>
    </div>
    <el-row class="main grid__row-gutter">
      <el-col class="grid__col-guttern" :span="18" v-loading="loading">
        <ul class="article">
          <li class="article__item" v-for="list, date in articles">
            <div class="article__month">{{ date }}</div>
            <ul class="article__list">
              <li class="article__body" v-for="item in list">
                <article-item :article="item" :key="item"></article-item>
              </li>
            </ul>
          </li>
        </ul>
        <div class="text-center load-more" v-if="showMoreBtn">
          <a class="load-more__btn" href="javascript:;" @click="getArticles">{{ loading ? '加载中...' : '浏览更多'}}</a>
        </div>
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
import assign from 'lodash/assign'
import * as statisticService from '@/services/statistics'
import * as articleService from '@/services/articles'
import { mapGetters } from 'vuex'

const formatDataWithMonth = function formatDataWithMonth(data) {
  const result = {}

  data.forEach((item) => {
    const date = item.udate.substring(0, 7)

    if (!result[date]) {
      result[date] = []
    }

    result[date].push(item)
  })

  return result
}

export default {
  name: 'ArticleList',
  data() {
    return {
      overview: {
        translators: 0,
        words: 0,
        articles: 0,
      },
      articles: {},
      loading: false,
      showMoreBtn: false,
      page: 1,
    }
  },
  computed: {
    ...mapGetters(['currentUser']),
  },
  methods: {
    getArticles() {
      const perPage = 100

      this.loading = true

      articleService.fetchArticles('posted', {
        page: this.page,
        per_page: perPage,
      }).then((data) => {
        this.loading = false

        if (data.length) {
          this.showMoreBtn = (data.length >= perPage)
          this.page += 1
        } else {
          this.showMoreBtn = false
          this.$message.warning('已经没有更多内容啦~')
        }

        assign(this.articles, formatDataWithMonth(data))
      }).catch((err) => {
        this.loading = false
        return this.$message.error(err.message)
      })
    },
  },
  created() {
    statisticService.fetchOverview().then((data) => {
      assign(this.overview, data)
    }).catch(err => this.$message.error(err.message))

    this.getArticles()
  },
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

.dashboard {
  padding-left: 0;
  margin-left: -30px;
  margin-top: 0;
  margin-bottom: 40px;
  list-style: none;

  &__box {
    overflow: hidden;
  }

  &__item {
    float: left;
    width: 340px;
    height: 120px;
    margin-left: 30px;
    color: #fff;
    border-radius: 6px;

    &--blue {
      background-color: #2db6f4;
    }

    &--green {
      background-color: #7dc856;
    }

    &--gray {
      background-color: #324057;
    }
  }

  &__body {
    margin-left: 50px;
    margin-top: 30px;
  }

  &__icon {
    float: left;
    padding-top: 8px;
    padding-right: 20px;
    font-size: 42px;
  }

  &__title {
    display: block;
    font-size: 14px;
  }

  &__number {
    font-size: 32px;
  }
}

.article {
  padding-right: 30px;
  min-height: 260px;

  &,
  &__list {
    padding-left: 0;
    list-style: none;
  }

  &__item {
    margin-bottom: 50px;
  }

  &__month {
    margin-bottom: 20px;
    font-size: 28px;
    color: $black-extra-light;
  }
}

.card {
  img {
    width: 100%;
    height: 200px;
  }
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
</style>
