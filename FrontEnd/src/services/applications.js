import axios from './axios'

export const fetchTexts = function fetchTexts(options) {
  return axios.get('/api/joinus/texts', { params: options })
}

export const submitRequest = function submitRequest(options) {
  return axios.post('/api/joinus/requests', options)
}
