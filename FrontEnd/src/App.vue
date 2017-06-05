<template>
  <div class="container-fluid">
    <navbar :user="user"></navbar>
    <router-view></router-view>
    <page-footer></page-footer>
  </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'

const store = require('store')

export default {
  name: 'app',
  data() {
    return {
      activeIndex: '1',
    }
  },
  computed: {
    ...mapState(['users']),
    user() {
      return this.$store.getters.currentUser
    },
  },
  methods: {
    ...mapMutations(['login']),
  },
  created() {
    let user = null

    // MOCK
    // eslint-disable-next-line
    window.__USER__ = '%7B%22id%22%3A%223%22%2C%22name%22%3A%22sqrthree%22%2C%22email%22%3A%22imsqrtthree%40gmail.com%22%2C%22avatar%22%3A%22https%3A%5C%2F%5C%2Favatars1.githubusercontent.com%5C%2Fu%5C%2F8622362%3Fv%3D3%22%2C%22status%22%3A%221%22%2C%22isadvanced%22%3A%220%22%2C%22isadmin%22%3A%220%22%2C%22istranslator%22%3A%220%22%2C%22udate%22%3A%222017-05-19+15%3A11%3A24%22%2C%22cdate%22%3A%222017-05-10+20%3A34%3A23%22%2C%22major%22%3Anull%2C%22bio%22%3A%22Full-Stack+Developer%22%2C%22token%22%3A%22a2927f8c644dfd98a2e8fbdd4c3791b8%22%7D'

    // eslint-disable-next-line
    if (window.__USER__) {
      try {
        // eslint-disable-next-line
        user = JSON.parse(decodeURIComponent(window.__USER__))
      } catch (err) {
        // eslint-disable-next-line
        console.error(err)
      }
    }

    if (user) {
      this.login(user)
      store.set('user', user)
    } else {
      // 长时间未登录导致 session 失效时需要清空本地数据
      store.remove('user')
    }
  },
}
</script>

<style lang="scss" scoped>
@import '~nprogress/nprogress.css';
@import "~styles/exports";

.navbar {
  background: #eef1f6;
}
</style>
