import axios from './axios'

export const logout = function logout() {
  return axios.get('/auth/logout')
}

export const fetchUserInfo = function fetchUserInfo(id) {
  return axios.get(`/api/users/${id}`)
}

export const validateInvitationCode = function validateInvitationCode(invitationCode) {
  return axios.post('/api/auth/validate-invitation-code', {
    invitationCode,
  })
}

export const fetchNotifications = function fetchNotifications() {
  return axios.get('/api/notifications')
}

export const fetchSettings = function fetchSettings(id) {
  return axios.get(`/api/UserSettings/${id}`)
}

export const updateSettings = function fetchSettings(id, payload) {
  return axios.post(`/api/UserSettings/${id}`, payload)
}

export const fetchTasksOfUser = function fetchTasksOfUser(id) {
  return axios.get(`/api/statistics/user/task/${id}`)
}
