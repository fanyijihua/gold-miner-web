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
