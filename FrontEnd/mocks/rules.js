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

  sleep(2).then(next)
})

router.get('/auth/login', (req, res) => {
  res.redirect('/#/joinus')
})

router.post('/auth/validate-invitation-code', (req, res) => {
  const random = Math.round(Math.random())

  if (random) {
    res.json({ isValid: true })
  } else {
    res.status(401).json({ message: '邀请码无效。' })
  }
})

router.get('/auth/logout', (req, res) => {
  res.end()
})

router.get('/joinus/texts', (req, res) => {
  const data = mock({
    'texts|10': [{
      id: 1,
      type: 'frontend',
      text: '@paragraph',
      creatorId: 1,
      createdAt: 1494422649139,
      updatedAt: 1494422649139,
    }],
  })

  data.texts.forEach((item, index) => {
    item.id = index + 1
    return item
  })

  res.json(data.texts)
})

router.post('/joinus/requests', (req, res) => {
  return res.json({
    email: req.body.email,
  })
})

router.get('/articles', (req, res) => {
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

module.exports = router
