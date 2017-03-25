const mock = require('mockjs').mock

module.exports = {
  'GET /api/auth/logout': function (req, res) {
    setTimeout(() => {
      res.json({})
    }, 1000)
  },
  'GET /api/user': function (req, res) {
    setTimeout(() => {
      const data = mock({
        id: '@id',
        username: '@cname',
        email: '@email',
      })

      res.json(data)
    }, 1000)
  },
}
