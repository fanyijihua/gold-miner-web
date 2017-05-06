<template>
  <div class="container join__container" v-loading="loading.status" :element-loading-text="loading.text">
    <el-steps :space="300" :align-center="true" :center="true" :active="active"process-status="finish" finish-status="success">
      <el-step title="填写资料"></el-step>
      <el-step title="进行试译"></el-step>
      <el-step title="提交申请"></el-step>
    </el-steps>
    <el-row class="join__info" v-if="active === 0">
      <el-col :span="11" :offset="6">
        <el-form ref="form" :model="userInfo" label-width="100px">
          <el-form-item label="邮箱" required>
            <el-input v-model="userInfo.email" placeholder="用于接收试译结果"></el-input>
          </el-form-item>
          <el-form-item label="擅长领域" required>
            <el-checkbox-group v-model="userInfo.skills">
              <el-checkbox label="前端" name="skills"></el-checkbox>
              <el-checkbox label="后端" name="skills"></el-checkbox>
              <el-checkbox label="Android" name="skills"></el-checkbox>
              <el-checkbox label="iOS" name="skills"></el-checkbox>
              <el-checkbox label="设计" name="skills"></el-checkbox>
              <el-checkbox label="产品" name="skills"></el-checkbox>
              <el-checkbox label="其他" name="skills"></el-checkbox>
            </el-checkbox-group>
          </el-form-item>
          <el-form-item label="英语能力简述">
            <el-input type="textarea" v-model="userInfo.ability"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitInfo">下一步</el-button>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
    <el-row class="translation" v-if="active === 1">
      <el-col :span="18" :offset="3">
        <h4 class="translation__title">请对下列一段英文进行翻译：</h4>
        <p class="translation__text">The push for SVG icons over font icons has caught serious momentum in the web community. With an SVG icon system you can better meet accessibility standards, render higher quality visuals, and add/remove/modify icons in the library with ease. At Pivotal we’ve created an SVG icon system with React for use on our suite of products. This article is about my approach to styling the SVG icon system with CSS to make it easy and effective to use.The push for SVG icons over font icons has caught serious momentum in the web community. With an SVG icon system you can better meet accessibility standards.</p>
        <h4>译文</h4>
        <el-form>
          <el-form-item>
            <el-input type="textarea" v-model="translation.result" :rows="8"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button class="pull-right" type="primary">下一步</el-button>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

const store = require('store')

export default {
  name: 'JoinUs',
  data() {
    return {
      active: 0,
      steps: [
        {},
      ],
      userInfo: {
        email: '',
        skills: [],
        ability: '',
      },
      translation: {
        original: '',
        result: '',
      },
    }
  },
  computed: {
    ...mapState(['user', 'loading']),
  },
  methods: {
    ...mapActions(['validateInvitationCode']),
    submitInfo() {
      const { email, skills, ability } = this.userInfo

      if (!email || !skills.length) return

      this.active = 1
      // eslint-disable-next-line
      console.log(email, skills, ability)
    },
  },
  created() {
    let invitationCode = this.$route.query['invitation-code']

    // 用户只有点击邀请链接才会以附带邀请码的形式访问该地址，此时应将邀请码
    // 存储至 localstorage 然后跳转至登录页面
    if (invitationCode) {
      store.set('invitationCode', invitationCode)
      window.location.href = '/api/auth/login'
      return
    }

    // 待登录后，如果不是译者，会跳转至该页面，然后尝试从
    // 本地存储中读取验证码并发起请求进行校验。
    invitationCode = store.get('invitationCode')

    if (invitationCode) {
      store.remove('invitationCode')
      this.validateInvitationCode(invitationCode).then((response) => {
        if (response.isValid) {
          this.$message.success('恭喜你成为了我们的新译者。')
          this.$router.replace('/')
        } else {
          this.$message.error('对不起，该邀请码无效。')
        }
      }).catch((err) => {
        this.$message.error(err.message)
      })
    }
  },
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

.join {
  &__container {
    margin-top: 40px;
  }

  &__info {
    margin-top: 50px;
  }
}

.translation {
  &__title {
    // font-size: 24px;
  }

  &__text {
    padding: 14px;
    border: 1px solid $gray;
    border-radius: 4px;
    line-height: 24px;
    font-size: 14px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  }
}
</style>
