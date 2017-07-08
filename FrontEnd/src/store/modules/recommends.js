import * as recommends from '@/services/recommends'

const state = {
  id: [],
  data: {},
}

const getters = {
  recommends(state) {
    return state.id.map(item => state.data[item])
  },
}

const mutations = {
  /**
   * 添加推荐的文章
   * @param {Object} payload 添加的文章数据
   */
  addRecommend(state, payload) {
    state.id.push(payload.id)
    state.data[payload.id] = payload
  },

  /**
   * 更新推荐文章列表
   * @param {Object} payload 最新推荐文章列表数据
   */
  initRecommend(state, payload) {
    state.id = payload.map(item => item.id)

    const data = {}

    payload.forEach((item) => {
      data[item.id] = item
    })

    state.data = data
  },

  /**
   * 删除推荐的文章
   * @param  {Number} id    要删除的数据的 id
   */
  removeRecommend(state, id) {
    const index = state.id.indexOf(id)

    if (index === -1) return

    state.id.splice(index, 1)
  },
}

const actions = {
  /**
   * 添加推荐的文章
   * @param {Object} payload 添加的文章数据
   */
  addRecommend(context, payload) {
    return recommends.addRecommend(payload).then((response) => {
      context.commit('addRecommend', response)

      return Promise.resolve(response)
    })
  },

  /**
   * 获取所有的推荐文章列表
   * @return {Promise}
   */
  fetchRecommends(context) {
    return recommends.fetchRecommends().then((response) => {
      context.commit('initRecommend', response)

      return Promise.resolve(response)
    })
  },

  /**
   * 提交审核意见
   * @param  {Object} payload 意见内容
   * @return {Promise}
   */
  submitOpinionOfRecommends(context, payload) {
    return recommends.submitOpinion(payload).then((response) => {
      context.commit('removeRecommend', payload.id)

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
