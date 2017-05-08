import axios from 'axios'
import nprogress from 'nprogress'

const instance = axios.create()

instance.interceptors.request.use((config) => {
  nprogress.start()
  return config
}, (error) => {
  nprogress.done()
  return Promise.reject(error)
})

instance.interceptors.response.use((response) => {
  nprogress.done()
  return response
}, (error) => {
  nprogress.done()
  return Promise.reject(error)
})

export default instance
