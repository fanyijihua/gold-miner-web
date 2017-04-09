const mock = require('mockjs').mock

module.exports = {
  'GET /api/articles': function (req, res) {
    setTimeout(() => {
      const data = mock({
        'articles|10': [{
          'id|+1': 1,
          title: '@ctitle',
          description: '@cparagraph',
          'category|1': ['前端', '后端', 'Android', 'iOS', '设计', '产品', '其他'],
          author: {
            'id|+1': 1,
            username: '@cname',
            avatar: '/static/avatar.png',
          },
          meta: {
            createdAt: '28 分钟前'
          }
        }]
      })

      res.json(data.articles)
    }, 3000)
  },
}
