import * as user from '@/services/user'

const state = {
  logIn: false,
  username: '',
  avatar: '',
  rules: [],
}

const getters = {
  getUserName: state => state.username,
}

const mutations = {
  login(state, payload) {
    Object.assign(state, payload, { logIn: true })
  },
  logout(state) {
    Object.assign(state, { logIn: false })
  },
}

const actions = {
  logout(context) {
    context.commit('showLoading')

    return user.logout().then(() => {
      context.commit('logout')
      context.commit('hideLoading')
    })
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
