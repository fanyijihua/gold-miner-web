<template>
  <div class="container-fluid">
    <navbar :user="user"></navbar>
    <router-view></router-view>
    <page-footer></page-footer>
  </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'

export default {
  name: 'app',
  data() {
    return {
      activeIndex: '1',
    }
  },
  computed: {
    ...mapState(['user']),
  },
  methods: {
    ...mapMutations(['login']),
  },
  created() {
    if (this.$route.query.login) {
      // eslint-disable-next-line
      window.__USER__ = JSON.stringify({
        id: 1,
        username: '根号三',
        avatar: '/static/avatar.png',
        rules: ['admin'],
      })
    }

    // eslint-disable-next-line
    if (window.__USER__) {
      // eslint-disable-next-line
      this.login(JSON.parse(window.__USER__))
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
