import union from 'lodash/union'
import assign from 'lodash/assign'
import * as user from '@/services/users'

const state = {
  oAuth: {
    logIn: false,
    token: '',
    id: '',
  },
  id: [],
  data: {},
}

const getters = {
  logIn: state => state.oAuth.logIn,
  currentUser: state => state.data[state.oAuth.id] || {},
}

const mutations = {
  /**
   * 用户登录后，将其标记为登录状态
   * @param  {Object} payload 登录的用户信息
   */
  login(state, payload) {
    if (!state.data[payload.id]) {
      state.id.push(payload.id)
      state.data[payload.id] = {}
    }

    state.oAuth.logIn = true
    state.oAuth.token = payload.token
    state.oAuth.id = payload.id

    assign(state.data[payload.id], payload)
  },

  /**
   * 用户退出后，将其标记为未登录状态
   * @param  {Object} payload 用户信息
   */
  logout(state) {
    assign(state.oAuth, {
      logIn: false,
      token: '',
      id: '',
    })
  },

  /**
   * 将用户信息更新至 store
   * @param  {Array} payload 需要更新的用户信息
   */
  updateUsers(state, payload) {
    if (!Array.isArray(payload)) throw new Error('payload is not an Array')
    if (!payload.length) return

    const idList = payload.map(item => item.id)
    const data = {}

    payload.forEach((item) => {
      data[item.id] = item
    })

    state.id = union(state.id, idList)
    state.data = assign({}, state.data, data)
  },
}

const actions = {
  /**
   * 验证邀请码是否有效
   * @param  {String} invitationCode 邀请码
   * @return {Promise}
   */
  validateInvitationCode(context, invitationCode) {
    context.commit('showLoading')
    context.commit('setLoadingText', '我们正在为您开辟专享通道，请稍后。')

    return user.validateInvitationCode(invitationCode).then((response) => {
      context.commit('hideLoading')
      return Promise.resolve(response)
    }).catch((err) => {
      context.commit('hideLoading')
      return Promise.reject(err)
    })
  },

  /**
   * 退出
   * @return {Promise}
   */
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
