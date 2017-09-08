<template>
  <div class="container-fluid">
    <navbar :user="user"></navbar>
    <router-view></router-view>
    <page-footer></page-footer>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

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
    ...mapActions(['fetchUserInfo']),
    showErrorMessageBox(errorMessage) {
      this.$alert(errorMessage, '啊，出错啦！', {
        confirmButtonText: '去 GitHub 设置',
        type: 'error',
        callback() {
          window.location.href = 'https://github.com/settings'
        },
      })
    },
  },
  created() {
    let user = null
    let isNewUser = false

    // eslint-disable-next-line
    if (window.__STORE__) {
      try {
        // eslint-disable-next-line
        const store = JSON.parse(window.atob(window.__STORE__))

        if (store.error) {
          this.showErrorMessageBox(store.error)
          return
        }

        user = store.user
        isNewUser = true
      } catch (err) {
        // eslint-disable-next-line
        console.error(err)
      }
    } else {
      user = store.get('user')
    }

    if (!user) return

    this.login(user)

    if (isNewUser) {
      store.set('user', user)

      if (user.translator) {
        this.$router.replace('/')
      } else {
        this.$router.replace('/applications/apply')
      }
    } else {
      this.fetchUserInfo(user.id).then((data) => {
        store.set('user', data)
      }).catch(err => this.$message.error(err.message))
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
