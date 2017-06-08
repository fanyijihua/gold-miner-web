import axios from './axios'

export const logout = function logout() {
  return axios.get('/auth/logout')
}

export const validateInvitationCode = function validateInvitationCode(invitationCode) {
  return axios.post('/api/auth/validate-invitation-code', {
    invitationCode,
  })
}

export const fetchNotifications = function fetchNotifications() {
  return axios.get('/api/notifications')
}
