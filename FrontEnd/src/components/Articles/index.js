import List from './src/List'

List.install = function install(Vue) {
  Vue.component(List.name, List)
}

export default List
