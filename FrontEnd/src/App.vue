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
    ...mapMutations(['setUserInfo']),
  },
  created() {
    // eslint-disable-next-line
    if (window.__USER__) {
      // eslint-disable-next-line
      this.setUserInfo(JSON.parse(window.__USER__))
    }
  },
}
</script>
</script>

<style lang="scss" scope>
@import "~styles/exports";

.navbar {
  background: #eef1f6;
}
</style>
