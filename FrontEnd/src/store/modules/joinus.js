import * as joinus from '@/services/joinus'

const state = {
  texts: {
    id: [],
    data: {},
  },
  requests: [],
}

const getters = {
}

const mutations = {
  /**
   * 将试译的英文稿进行存储
   * @param {Array} payload 试译的英文稿数据
   */
  addTexts(state, payload) {
    payload.forEach((item) => {
      if (!state.texts.id.includes(item.id)) {
        state.texts.id.push(item.id)
      }

      state.texts.data[item.id] = item
    })
  },
}

const actions = {
  /**
   * 获取试译的英文稿
   * @param  {Array} payload 指定要获取的类别
   * @return {Promise}
   */
  fetchTexts(context, payload) {
    context.commit('showLoading')

    return joinus.fetchTexts(payload).then((response) => {
      context.commit('hideLoading')
      context.commit('addTexts', response.data)
      return Promise.resolve(response.data)
    }).catch((err) => {
      context.commit('hideLoading')
      return Promise.reject(err.response.data)
    })
  },

  /**
   * 提交翻译的译文和最终数据
   * @param  {Object} payload 申请信息和翻译结果
   * @return {Promise}
   */
  submitRequest(context, payload) {
    context.commit('showLoading')

    return joinus.submitRequest(payload).then((response) => {
      context.commit('hideLoading')
      return Promise.resolve(response.data)
    }).catch((err) => {
      context.commit('hideLoading')
      return Promise.reject(err.response.data)
    })
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
