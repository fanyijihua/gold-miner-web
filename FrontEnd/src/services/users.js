import axios from './axios'

export const logout = function logout() {
  return axios.get('/auth/logout')
}

export const fetchCurrentUserInfo = function fetchCurrentUserInfo() {
  return axios.get('/api/users/pull')
}

export const fetchUserInfo = function fetchUserInfo(id) {
  return axios.get(`/api/users/${id}`)
}

export const validateInvitationCode = function validateInvitationCode(payload) {
  return axios.post('/api/applicants/check', payload)
}

export const fetchNotifications = function fetchNotifications() {
  return axios.get('/api/notifications')
}

export const fetchSettings = function fetchSettings() {
  return axios.get('/api/usersettings')
}

export const updateSettings = function fetchSettings(payload) {
  return axios.post('/api/usersettings', payload)
}

export const fetchTasksOfUser = function fetchTasksOfUser(id) {
  return axios.get(`/api/statistics/user/task/${id}`)
}
