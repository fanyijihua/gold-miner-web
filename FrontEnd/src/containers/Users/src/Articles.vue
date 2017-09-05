<template>
  <div class="container">
    <el-row :gutter="20">
      <el-col :span="8">
        <card title="翻译的文章" size="small">
          <ul class="article__list">
            <li class="article__item" v-for="item in articles.translate">
              <span class="article__dot"></span>
              <div class="article__body">
                <h4 class="article__title">{{ item.title }}</h4>
              </div>
              <a class="article__url" :href="item.link">查看详情</a>
            </li>
          </ul>
        </card>
      </el-col>
      <el-col :span="8">
        <card title="校对的文章" size="small">
          <ul class="article__list">
            <li class="article__item" v-for="item in articles.review">
              <span class="article__dot"></span>
              <div class="article__body">
                <h4 class="article__title">{{ item.title }}</h4>
              </div>
              <a class="article__url" :href="item.link">查看详情</a>
            </li>
          </ul>
        </card>
      </el-col>
      <el-col :span="8">
        <card title="推荐的文章" size="small">
          <ul class="article__list">
            <li class="article__item" v-for="item in articles.recommend">
              <span class="article__dot"></span>
              <div class="article__body">
                <h4 class="article__title">{{ item.title }}</h4>
              </div>
              <a class="article__url" :href="item.link">查看详情</a>
            </li>
          </ul>
        </card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import * as userService from '@/services/users'
import assign from 'lodash/assign'

export default {
  name: 'UserArticles',
  data() {
    return {
      loading: false,
      articles: {
        translate: [],
        review: [],
        recommend: [],
      },
    }
  },
  created() {
    const { id } = this.$route.params

    userService.fetchTasksOfUser(id).then((data) => {
      assign(this.articles, data)
    }).catch((err) => {
      this.$message.error(err.message)
    })
  },
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

.article {
  &__list {
    padding-left: 0;
    list-style: none;
  }

  &__item {
    position: relative;
    height: 32px;
    line-height: 32px;
    @include clearfix();
  }

  &__dot,
  &__body,
  &__url {
    float: left;
  }

  &__dot {
    position: absolute;
    top: 14px;
    display: block;
    width: 4px;
    height: 4px;
    margin-right: -5px;
    border-radius: 50%;
    background: $blue;
  }

  &__body {
    width: 100%;
  }

  &__title {
    margin: 0;
    margin-left: 12px;
    margin-right: 50px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    font-size: 14px;
    font-weight: 400;
  }

  &__url {
    margin-left: -48px;
    font-size: 12px;
    color: $blue;
  }
}
</style>
