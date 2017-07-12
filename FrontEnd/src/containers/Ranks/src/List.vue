<template>
  <div class="rank container">
    <div class="rank__list">
      <el-row :gutter="20">
        <el-col :span="8">
          <card title="推荐月榜" size="small">
            <ranking-list :data="mockData">
              <ranking-column prop="index" label="排名"></ranking-column>
              <ranking-column prop="name" label="译者"></ranking-column>
              <ranking-column prop="total" label="翻译文章"></ranking-column>
            </ranking-list>
          </card>
        </el-col>
        <el-col :span="8">
          <card title="推荐年榜" size="small">
            <ranking-list :data="mockData">
              <ranking-column prop="index" label="排名"></ranking-column>
              <ranking-column prop="name" label="译者"></ranking-column>
              <ranking-column prop="total" label="翻译文章"></ranking-column>
            </ranking-list>
          </card>
        </el-col>
        <el-col :span="8">
          <card title="推荐总榜" size="small">
            <ranking-list :data="mockData">
              <ranking-column prop="index" label="排名"></ranking-column>
              <ranking-column prop="name" label="译者"></ranking-column>
              <ranking-column prop="total" label="翻译文章"></ranking-column>
            </ranking-list>
          </card>
        </el-col>
      </el-row>
    </div>
    <div class="rank__list">
      <el-row :gutter="20">
        <el-col :span="8">
          <card title="翻译月榜" size="small">
            <ranking-list :data="mockData">
              <ranking-column prop="index" label="排名"></ranking-column>
              <ranking-column prop="name" label="译者"></ranking-column>
              <ranking-column prop="total" label="翻译文章"></ranking-column>
            </ranking-list>
          </card>
        </el-col>
        <el-col :span="8">
          <card title="翻译年榜" size="small">
            <ranking-list :data="mockData">
              <ranking-column prop="index" label="排名"></ranking-column>
              <ranking-column prop="name" label="译者"></ranking-column>
              <ranking-column prop="total" label="翻译文章"></ranking-column>
            </ranking-list>
          </card>
        </el-col>
        <el-col :span="8">
          <card title="翻译总榜" size="small">
            <ranking-list :data="mockData">
              <ranking-column prop="index" label="排名"></ranking-column>
              <ranking-column prop="name" label="译者"></ranking-column>
              <ranking-column prop="total" label="翻译文章"></ranking-column>
            </ranking-list>
          </card>
        </el-col>
      </el-row>
    </div>
    <div class="rank__list">
      <el-row :gutter="20">
        <el-col :span="8">
          <card title="校对月榜" size="small">
            <ranking-list :data="mockData">
              <ranking-column prop="index" label="排名"></ranking-column>
              <ranking-column prop="name" label="译者"></ranking-column>
              <ranking-column prop="total" label="翻译文章"></ranking-column>
            </ranking-list>
          </card>
        </el-col>
        <el-col :span="8">
          <card title="校对年榜" size="small">
            <ranking-list :data="mockData">
              <ranking-column prop="index" label="排名"></ranking-column>
              <ranking-column prop="name" label="译者"></ranking-column>
              <ranking-column prop="total" label="翻译文章"></ranking-column>
            </ranking-list>
          </card>
        </el-col>
        <el-col :span="8">
          <card title="校对总榜" size="small">
            <ranking-list :data="mockData">
              <ranking-column prop="index" label="排名"></ranking-column>
              <ranking-column prop="name" label="译者"></ranking-column>
              <ranking-column prop="total" label="翻译文章"></ranking-column>
            </ranking-list>
          </card>
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
const mockData = []

let num = 10

// eslint-disable-next-line
while(num --) {
  mockData.push({
    index: mockData.length + 1,
    name: 'username',
    // eslint-disable-next-line
    total: Math.floor(Math.random() * 100 + 100),
  })
}

export default {
  name: 'Rank',
  data() {
    return {
      mockData,
    }
  },
}
</script>

<style lang="scss" scoped>
.rank {
  margin-top: 40px;

  &__list {
    margin-bottom: 30px;
  }
}
</style>
