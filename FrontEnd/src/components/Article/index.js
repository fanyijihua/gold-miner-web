import Article from './src/ArticleItem'

Article.install = function install(Vue) {
  Vue.component(Article.name, Article)
}

export default Article
