<template>
  <div class="container">
    <el-row class="main grid__row-gutter">
      <el-col class="grid__col-gutter" :span="18">
        <articles></articles>
      </el-col>
      <el-col class="grid__col-gutter" :span="6">
        <div class="card">
          <h3 class="card__title">编辑精选</h3>
          <div><img class="img-rounded" src="http://upload-images.jianshu.io/upload_images/1315889-06996eba6ac2c4f7.png" alt=""></div>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
// import Articles from '@/components/articles'

export default {
  name: 'Index',
  components: {
    // articles: Articles.List,
  },
}
</script>

<style lang="scss" scoped>
@import "~styles/exports";

.main {
  margin-top: $grid-gutter-width * 1.5;
}
.grid__row-gutter {
  margin-left: floor(-$grid-gutter-width / 2);
  margin-right: ceil(-$grid-gutter-width / 2);
}
.grid__col-gutter {
  padding-left: floor($grid-gutter-width / 2);
  padding-right: ceil($grid-gutter-width / 2);
}

.card {
  &__title {
  }

  img {
    width: 100%;
    height: 200px;
  }
}
</style>
