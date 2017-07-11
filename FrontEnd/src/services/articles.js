import axios from './axios'

export const fetchArticles = function fetchArticles(options) {
  return axios.get('/api/translations', {
    params: options,
  })
}

export const test = function test() {

}
