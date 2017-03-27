const state = {
  text: '',
  status: false,
}

const mutations = {
  showLoading(state) {
    state.status = true
  },
  hideLoading(state) {
    state.status = false
  },
  setLoadingText(state, text) {
    state.text = text
  },
}

export default {
  state,
  mutations,
}
