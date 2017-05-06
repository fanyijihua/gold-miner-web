const express = require('express')
const chalk = require('chalk')
const mock = require('mockjs').mock

const router = express.Router()

const id = function id() {
  return Math.random().toString().substring(2)
}

const sleep = function sleep(second) {
  return new Promise((resolve) => {
    setTimeout(resolve, second * 1000)
  })
}

router.all('*', (req, res, next) => {
  console.log()
  console.log(`${chalk.green(req.method)} ${chalk.gray(req.url)}`)

  if (Object.keys(req.query).length) {
    console.log(`query:  ${JSON.stringify(req.query)}`)
  }

  if (Object.keys(req.body).length) {
    console.log(`body:   ${JSON.stringify(req.body)}`)
  }

  next()
})

router.get('/auth/login', (req, res) => {
  sleep(2).then(() => {
    res.redirect('/#/joinus')
  })
})

router.post('/auth/validate-invitation-code', (req, res) => {
  const random = Math.round(Math.random())

  sleep(2).then(() => {
    if (random) {
      res.json({ isValid: true })
    } else {
      res.status(401).json({ message: '邀请码无效。' })
    }
  })
})

router.get('/auth/logout', (req, res) => {
  sleep(2).then(() => {
    res.end()
  })
})

router.get('/articles', (req, res) => {
  sleep(3).then(() => {
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
          createdAt: '28 分钟前',
        },
      }],
    })

    res.json(data.articles)
  })
})

module.exports = router
