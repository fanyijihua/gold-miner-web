import Vue from 'vue'
import { sync } from 'vuex-router-sync'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import './styles/index.scss'

import Components from './components'
import store from './store'
import router from './router'
import App from './App'

sync(store, router)

Vue.config.productionTip = false

Vue.use(ElementUI)
Vue.use(Components)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App },
})
