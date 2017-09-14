import axios from './axios'

export const fetchRecommends = function fetchRecommends() {
  return axios.get('/api/recommends')
}

export const addRecommend = function addRecommend(payload) {
  return axios.post('/api/recommends', payload)
}

export const submitOpinion = function submitOpinion(payload) {
  return axios.put(`/api/recommends/result/${payload.id}`, payload)
}
