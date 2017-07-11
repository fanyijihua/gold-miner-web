<template>
  <div class="article-detail container">
    <div class="article-detail__information">
      <article-item :article="article" :key="article.id">
        <div slot="meta" class="article__links article-detail__meta">
          <a class="article__link" href="">原文链接</a>
          <a class="article__link" href="">Markdown 文件</a>
        </div>
        <div slot="footer" class="article__tags">
          <span class="article__tag">推荐于 2017-07-11</span>
          <span class="article__tag">设计</span>
          <span class="article__tag">翻译时间：10 天</span>
          <span class="article__tag">校对时间：2 天</span>
          <span class="article__tag">翻译积分：10</span>
          <span class="article__tag">校对积分：10</span>
        </div>
      </article-item>
      <div class="article-detail__toolbar clearfix">
        <el-button class="pull-right" type="primary">认领翻译</el-button>
      </div>
    </div>
    <div class="timeline">
      <div class="timeline__header">
        <div class="timeline__divider"></div>
        <h3 class="timeline__title">时间线</h3>
      </div>
      <div class="timeline__body">
        <timeline :data="timeline"></timeline>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ArticleDetail',
  data() {
    return {
      article: {
        id: 1,
        title: '带快算带快议花转万七党点安带快算',
        description: '区叫强界和议花转万七党点安。音立过际度始事质还容知已。文电计相海王志一立地精将展实要。三图候五取音部具受适则门。',
        category: 'iOS',
        author: {
          id: 1,
          username: '根号三',
          avatar: '/static/images/default-avatar.png',
        },
        status: 2,
        meta: {
          createdAt: '28 分钟前',
        },
      },
      timeline: ['根号三 20 分钟前推荐', '根号三 19 分钟前认领翻译', '正在翻译中'],
    }
  },
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

.article-detail {
  width: 70%;

  &__information {
    padding: 20px;
    border: 1px solid $gray-extra-light;
    border-radius: 6px;
    background-color: $drak-white;
  }

  &__meta {
    margin-bottom: 10px;
  }

  &__icon {
    font-size: 24px;
  }

  &__toolbar {
    margin-top: 30px;
  }
}

.timeline {
  position: relative;
  margin-top: 60px;

  &__divider {
    position: absolute;
    top: 15px;
    z-index: -1;
    width: 100%;
    height: 1px;
    background: $gray-light;
  }

  &__title {
    display: inline-block;
    margin: 0;
    padding-right: 10px;
    background-color: #fff;
  }

  &__body {
    padding: 30px 40px;
  }
}
</style>
