import * as user from '@/services/users'

const state = {
  system: [],
}

const getters = {
  total(state, getters, rootState) {
    const { applications, recommends } = rootState
    let result = 0

    if (getters.currentUser.admin) {
      result = state.system.length
        + applications.applicants.id.length
        + recommends.id.length
    } else {
      result = state.system.length
    }

    return result
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
      context.commit('updateNotifications', response)

      return Promise.resolve(response)
    })
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
