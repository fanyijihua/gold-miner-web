import axios from 'axios'

export const logout = function logout() {
  return axios.get('/api/auth/logout')
}

export const user = function logout() {
  return axios.get('/api/user')
}
