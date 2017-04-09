const mock = require('mockjs').mock

module.exports = {
  'GET /api/auth/logout': function (req, res) {
    setTimeout(() => {
      res.json({})
    }, 2000)
  },
}
