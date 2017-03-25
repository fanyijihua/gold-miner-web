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
  setUserInfo(state, payload) {
    Object.assign(state, state, payload, { logIn: true })
  },
  removeCurrentUser(state) {
    Object.assign(state, { logIn: false })
  },
}

const actions = {
  logout(context) {
    return user.logout().then(() => {
      context.commit('removeCurrentUser')
    })
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
