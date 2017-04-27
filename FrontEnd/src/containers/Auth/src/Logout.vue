<template>
  <div class="callback container">
    <div class="result-alerts text-center" v-loading="loading.status" element-loading-text="我们正在处理一些事情">
      <el-alert v-if="!loading.status" :title="`退出成功，${seconds} 秒后将自动为您跳转至首页。`" type="success" :closable="false" show-icon></el-alert>
    </div>
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
      const timer = setInterval(() => {
        this.seconds -= 1

        if (this.seconds <= 0) {
          clearInterval(timer)
          location.href = '/'
        }
      }, 1000)
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
