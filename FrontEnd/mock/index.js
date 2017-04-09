const _ = require('lodash')
const user = require('./user')
const articles = require('./articles')

const routes = _.assign({}, user, articles)

module.exports = routes
