<template>
  <div class="callback container">
    <div class="result-alerts text-center" v-loading="loading.status" element-loading-text="正在退出..."></div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  name: 'Logout',
  data() {
    return {
      seconds: 3,
    }
  },
  computed: {
    ...mapState(['user', 'loading']),
  },
  methods: {
    ...mapActions(['logout']),
  },
  created() {
    const logoutCallback = () => {
      this.$message.success('退出成功。')
      this.$router.replace('/')
    }

    this.logout().then(logoutCallback).catch(logoutCallback)
  },
}
</script>

<style lang="scss" scoped>
.callback {
  min-height: 320px;
}
.result-alerts {
  width: 400px;
  margin-top: 168px;
  margin-left: auto;
  margin-right: auto;
}
</style>
