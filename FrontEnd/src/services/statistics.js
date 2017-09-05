import axios from './axios'

export const fetchOverview = function fetchOverview() {
  return axios.get('/api/statistics/overview')
}

export const fetchRanks = function fetchRanks() {
  return axios.get('/api/statistics')
}

export const fetchRankOfUser = function fetchRankOfUser(id) {
  return axios.get(`/api/statistics/user/rank/${id}`)
}
