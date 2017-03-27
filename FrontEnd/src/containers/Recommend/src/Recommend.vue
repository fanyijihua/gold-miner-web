<template>
  <el-row class="recomment">
    <el-col :span="10" :offset="7">
      <h1 class="text-center">推荐优质英文文章</h1>
      <el-form ref="form" :model="form" label-width="100px">
        <el-form-item label="文章地址" required>
          <el-input v-model="form.url"></el-input>
        </el-form-item>
        <el-form-item label="文章标题" required>
          <el-input v-model="form.title"></el-input>
        </el-form-item>
        <el-form-item label="所属分类" required>
          <el-select v-model="form.category" placeholder="请选择文章所属的类别">
            <el-option label="前端" value="frontent"></el-option>
            <el-option label="后端" value="backend"></el-option>
            <el-option label="Android" value="android"></el-option>
            <el-option label="iOS" value="ios"></el-option>
            <el-option label="设计" value="design"></el-option>
            <el-option label="产品" value="product"></el-option>
            <el-option label="其他" value="others"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="文章介绍" required>
          <el-input type="textarea" v-model="form.description"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="onSubmit">立即推荐</el-button>
        </el-form-item>
      </el-form>
    </el-col>
  </el-row>
</template>

<script>
export default {
  name: 'Recommend',
  data() {
    return {
      form: {
        url: '',
        title: '',
        category: '',
        description: '',
      },
    }
  },
  methods: {
    onSubmit() {
    },
  },
}
</script>

<style lang="scss" scoped>
.recomment {
  margin-top: 30px;
}
</style>
