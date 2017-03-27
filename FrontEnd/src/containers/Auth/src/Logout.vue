<template>
  <div class="callback container" v-loading="loading" element-loading-text="我们正在处理一些事情">
    <div class="result-alerts text-center">
      <el-alert v-if="!loading" :title="`退出成功，${seconds} 秒后将自动为您跳转至首页。`" type="success" :closable="false" show-icon></el-alert>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'Logout',
  data() {
    return {
      loading: true,
      seconds: 3,
    }
  },
  methods: {
    ...mapActions(['logout']),
  },
  created() {
    const logoutCallback = () => {
      this.loading = false

      const timer = setInterval(() => {
        this.seconds -= 1

        if (this.seconds <= 0) {
          clearInterval(timer)
          location.href = '/?logout=true'
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
