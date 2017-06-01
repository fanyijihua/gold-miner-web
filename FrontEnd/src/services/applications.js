import axios from './axios'

export const fetchRandomText = function fetchRandomText(category) {
  return axios.get(`/api/articles/random/${category}`)
}

export const fetchTexts = function fetchTexts(options) {
  return axios.get('/api/applications/texts', { params: options })
}

export const addText = function addText(options) {
  return axios.post('/api/applications/texts', options)
}

export const updateText = function updateText(options) {
  return axios.put(`/api/applications/texts/${options.id}`, options)
}

export const deleteText = function deleteText(id) {
  return axios.delete(`/api/applications/texts/${id}`)
}

export const fetchApplicants = function fetchApplicants() {
  return axios.get('/api/applications/applicants')
}

export const submitApplication = function submitRequest(options) {
  return axios.post('/api/applications/applicants', options)
}

export const submitOpinion = function submitOpinion(options) {
  return axios.post(`/api/applications/applicants/${options.id}/opinions`, options)
}
