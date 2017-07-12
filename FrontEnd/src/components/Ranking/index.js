import RankingList from './src/List'
import RankingColumn from './src/Column'

RankingList.install = function install(Vue) {
  Vue.component(RankingList.name, RankingList)
}

RankingColumn.install = function install(Vue) {
  Vue.component(RankingColumn.name, RankingColumn)
}

export {
  RankingList,
  RankingColumn,
}
