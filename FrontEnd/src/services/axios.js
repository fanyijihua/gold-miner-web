import axios from 'axios'
import nprogress from 'nprogress'

const store = require('store')

const instance = axios.create()

instance.interceptors.request.use((config) => {
  const { token } = store.get('user') || {}

  config.headers.Authorization = token

  nprogress.start()

  return config
}, (error) => {
  nprogress.done()
  return Promise.reject(error)
})

instance.interceptors.response.use((response) => {
  nprogress.done()
  return Promise.resolve(response.data)
}, (err) => {
  nprogress.done()

  // 身份认证失败
  if (err.response.status === 401) {
    store.remove('user')
  }

  err.response.data.status = err.response.status

  return Promise.reject(err.response.data)
})

export default instance
