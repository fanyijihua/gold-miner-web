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
  validateInvitationCode(context, invitationCode) {
    context.commit('showLoading')
    context.commit('setLoadingText', '我们正在为您开辟专享通道，请稍后。')

    return user.validateInvitationCode(invitationCode).then((response) => {
      context.commit('hideLoading')
      return Promise.resolve(response.data)
    }).catch((err) => {
      context.commit('hideLoading')
      return Promise.reject(err.response.data)
    })
  },
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
