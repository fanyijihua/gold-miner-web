<template>
  <div class="article__item clearfix">
    <div class="article__author pull-left text-center" v-if="article.author">
      <img class="img-responsive img-circle" :src="article.author.avatar" alt="">
      <router-link class="article__author-username" :to="`/users/${article.author.id}`">{{ article.author.username }}</router-link>
    </div>
    <div class="article__cont">
      <h3 class="article__title">{{ article.title }}</h3>
      <p class="article__description">{{ article.description }}</p>
      <div class="article__footer clearfix">
        <div class="article__tags pull-left">
          <span class="article__tag">{{ article.category }}</span>
          <span class="article__tag">{{ article.meta.createdAt }}</span>
        </div>
        <div class="article__links pull-right">
          <a class="article__link" href="https://juejin.im/articles/1">收藏该文章</a>
          <router-link class="article__link" :to="`/articles/${article.id}`">阅读全文</router-link>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'articleItem',
  props: ['article'],
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

.article {
  &__item {
    margin-bottom: 16px;
  }

  &__author {
    width: 10%;
    padding: 10px;
    @include border-box();

    img {
      width: 100%;
      height: 100%;
    }
  }

  &__author-username {
    display: block;
    margin-top: 4px;
    font-size: 12px;
    color: $primary;
  }

  &__cont {
    padding-left: 10%;
  }

  &__title {
    padding: 8px 0 5px;
    margin: 0;
    font-size: 16px;
    font-weight: 400;
  }

  &__description {
    margin: 0;
    font-size: 14px;
    color: $silver;
  }

  &__footer {
    margin-top: 5px;
  }

  &__tag {
    margin-right: 20px;
    font-size: 12px;
    color: #999;

    &:before {
      margin-right: 4px;
      content: '·';
      font-weight: 900;
      color: $primary;
    }
  }

  &__links {
    font-size: 0;
  }

  &__link {
    font-size: 12px;
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
