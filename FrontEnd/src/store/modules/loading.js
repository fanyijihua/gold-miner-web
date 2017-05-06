const state = {
  text: '拼命加载中',
  status: false,
}

const mutations = {
  showLoading(state) {
    state.status = true
  },
  hideLoading(state) {
    state.status = false
    state.text = '拼命加载中'
  },
  setLoadingText(state, text) {
    state.text = text
  },
}

export default {
  state,
  mutations,
}
