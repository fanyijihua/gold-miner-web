<template>
  <router-link class="article__item clearfix" :to="`/articles/${article.id}/details`">
    <div class="article__poster">
      <img :src="article.poster" alt="">
    </div>
    <div class="article__content">
      <h3 class="article__title">{{ article.title || article.oTitle }}</h3>
      <p class="article__intro">{{ article.description || article.oDescription }}</p>
      <div class="article__footer clearfix">
        <div class="pull-left">
          <span class="article__user-info">{{ article.status === 0 ? article.recommender.name : article.translator.name }} · </span>
          <span class="article__tag">{{ article.category }} · </span>
          <span class="article__date">{{ article.status === 0 ? article.oCdate : article.udate }}</span>
        </div>
        <div class="pull-right">
          <slot name="info">
            <span class="article__action">{{ mapStatusToText(article.status) }}</span>
          </slot>
        </div>
      </div>
    </div>
  </router-link>
</template>
<script>
export default {
  name: 'articleItem',
  props: ['article'],
  methods: {
    mapStatusToText(status) {
      const texts = {
        0: '等待翻译',
        1: '正在翻译',
        2: '等待校对',
        3: '正在校对',
        4: '阅读全文',
      }

      return texts[status]
    },
  },
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

.article {
  &__item {
    display: block;
    padding: 16px;
    border-bottom: 1px solid $gray-extra-light;
    border-radius: 4px;

    &:last-of-type {
      border-bottom: none;
    }

    &:hover {
      background-color: $gray-extra-light;
    }
  }

  &__poster {
    float: left;
    width: 260px;
  }

  &__poster img {
    width: 100%;
    height: auto;
    border-radius: 4px;
  }

  &__content {
    margin-left: 280px;
  }

  &__title {
    margin: 0;
    font-size: 22px;
    font-weight: 400;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  &__intro {
    height: 116px;
    font-size: 14px;
    line-height: 24px;
    overflow: hidden;
    hyphens:auto;
  }

  &__footer {
    font-size: 14px;
    color: $silver;
  }
}
</style>
