import * as user from '@/services/users'

const state = {
  system: [],
}

const getters = {
  total(state, getters, rootState) {
    const { applications, recommends } = rootState

    return state.system.length
      + applications.applicants.id.length
      + recommends.id.length
  },
}

const mutations = {
  /**
   * 更新当前用户的通知消息内容
   */
  updateNotifications(state, payload) {
    state.system = payload
  },
}

const actions = {
  /**
   * 获取当前用户的通知消息
   * @return {Promise}
   */
  fetchNotifications(context) {
    return user.fetchNotifications().then((response) => {
      context.commit('updateNotifications', response.data)

      return Promise.resolve(response.data)
    }).catch(err => Promise.reject(err.response.data))
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
