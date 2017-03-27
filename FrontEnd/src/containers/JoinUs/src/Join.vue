<template>
  <div class="container join__container">
    <el-steps :space="300" :align-center="true" :center="true" :active="active"process-status="finish" finish-status="success">
      <el-step title="填写资料"></el-step>
      <el-step title="进行试译"></el-step>
      <el-step title="提交申请"></el-step>
    </el-steps>
    <el-row class="join__info">
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
          <el-form-item label="英语能力">
            <el-input type="textarea" v-model="userInfo.ability"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitInfo">下一步</el-button>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
    <!-- <el-row class="translation">
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
    </el-row> -->
  </div>
</template>

<script>
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
  methods: {
    submitInfo() {
      // eslint-disable-next-line
      console.log(this.userInfo.ability)
    },
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
