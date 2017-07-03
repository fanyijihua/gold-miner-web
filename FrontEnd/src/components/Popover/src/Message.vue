<template>
  <ul class="message">
    <li class="message__item" v-if="!messages.length">
      <div class="message__content">
        <div class="message__title">这里空空如也~</div>
      </div>
    </li>
    <li class="message__item" v-else v-for="message in messages">
      <img class="message__avatar img-circle pull-left" src="/static/images/avatar.png" alt="">
      <div class="message__content">
        <div class="message__title">{{ message.title }}</div>
        <div class="message__body"></div>
        <div class="message__footer">
          <span class="message__date">{{ message.cdate }}</span>
          <router-link class="message__link pull-right" :to="`${message.url}`">去处理</router-link>
        </div>
      </div>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'PopoverMessage',
  props: ['data', 'type'],
  computed: {
    messages() {
      if (!this.data || !this.data.length) return []

      const title = {
        applicants: '申请成为译者',
        recommends: '推荐了优秀文章',
      }

      const url = {
        applicants: '/applications/applicants',
        recommends: '/recommends',
      }

      return this.data.map(item => ({
        title: title[this.type],
        cdate: item.cdate,
        url: `${url[this.type]}/${item.id}`,
      }))
    },
  },
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

.message {
  width: 300px;
  margin: 0;
  padding-left: 0;
  list-style: none;

  &__item {
    @include clearfix();
    margin-bottom: 10px;
  }

  &__avatar {
    width: 3em;
  }

  &__content {
    margin-left: 42px;
  }

  &__title {
    @include ellipsis();
    font-size: 13px;
    color: $black-extra-light;
  }

  &__body {
    margin: 4px 0;
    color: $silver;
  }

  &__date {
    color: $silver-light;
  }

  &__link {
    color: $blue-light;
  }
}
</style>
