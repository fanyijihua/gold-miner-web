<template>
  <div class="article__box">
    <div class="article__metacle clearfix">
      <div class="article__tags pull-left">
        <span class="article__tag">iOS</span>
        <span class="article__tag">2017-07-10</span>
      </div>
      <div class="article__links pull-right">
        <a href="" class="article__link">去掘金收藏该文章</a>
      </div>
    </div>
    <div class="article__content">
      <h1>文章正文内容</h1>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ArticleItem',
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

.article {
  &__box {
    min-height: 400px;
    padding: 30px 40px;
    border: 1px solid $gray;
    border-radius: 6px;
  }

  &__meta {
    font-size: 16px;
  }

  &__tag {
    margin-right: 20px;
    color: $silver;

    &:before {
      margin-right: 4px;
      content: '·';
      font-weight: 900;
      color: $primary;
    }
  }

  &__link {
    color: $primary;

    &:after {
      margin: 0 4px;
      content: '|';
      vertical-align: text-top;
      color: $silver-extra-light;
    }

    &:last-child:after {
      display: none;
    }
  }
}
</style>
