<template>
  <div class="container">
    <el-row :gutter="20">
      <el-col :span="8">
        <card title="翻译的文章" size="small">
          <ul class="article__list">
            <li class="article__item" v-for="item in translations">
              <span class="article__dot"></span>
              <div class="article__body">
                <h4 class="article__title">{{ item.title }}</h4>
              </div>
              <a class="article__url" href="#">查看详情</a>
            </li>
          </ul>
        </card>
      </el-col>
      <el-col :span="8">
        <card title="校对的文章" size="small">
          <ul class="article__list">
            <li class="article__item" v-for="item in translations">
              <span class="article__dot"></span>
              <div class="article__body">
                <h4 class="article__title">{{ item.title }}</h4>
              </div>
              <a class="article__url" href="#">查看详情</a>
            </li>
          </ul>
        </card>
      </el-col>
      <el-col :span="8">
        <card title="推荐的文章" size="small">
          <ul class="article__list">
            <li class="article__item" v-for="item in translations">
              <span class="article__dot"></span>
              <div class="article__body">
                <h4 class="article__title">{{ item.title }}</h4>
              </div>
              <a class="article__url" href="#">查看详情</a>
            </li>
          </ul>
        </card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
const data = [
  {
    id: 1,
    title: '如何为超级复杂如此复杂真的很复杂的真的很复杂的',
  },
  {
    id: 2,
    title: '我是译者本人，这是我翻译的文章',
  },
  {
    id: 3,
    title: '如何为复杂应用设计表单',
  },
  {
    id: 4,
    title: '杂如此复杂真的很',
  },
  {
    id: 5,
    title: '如何为超级复杂如此复的真的很复杂的',
  },
]

export default {
  name: 'UserArticles',
  data() {
    return {
      translations: data,
    }
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
