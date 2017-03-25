<template>
  <div class="popover">
    <el-tabs v-model="active">
      <el-tab-pane v-if="messages.users" label="译者申请" name="users">
        <message :messages="messages.users"></message>
      </el-tab-pane>
      <el-tab-pane v-if="messages.articles" label="推荐的文章" name="articles">
        <message :messages="messages.articles"></message>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import Message from './Message'

const mock = {
  users: [
    {
      title: '申请译者',
      body: '',
      user: {
        id: '1',
        username: 'ABC',
        avatar: '/static/avatar.png',
      },
      date: '2017-01-11',
      link: '/joinus/users/1',
    },
    {
      title: '申请译者',
      body: '',
      user: {
        id: '1',
        username: 'DEF',
        avatar: '/static/avatar.png',
      },
      date: '2017-03-25',
      link: '/joinus/users/2',
    },
  ],
  articles: [
    {
      title: '推荐文章《如何为复杂应用设计表单》',
      body: '',
      user: {
        id: '1',
        username: '根号三',
        avatar: '/static/avatar.png',
      },
      date: '2017-01-11',
      link: '/articles/1/referrals',
    },
  ],
}

export default {
  name: 'Popover',
  components: {
    message: Message,
  },
  data() {
    return {
      active: 'users',
      messages: mock,
    }
  },
}
</script>

<style lang="scss" scope>
</style>
