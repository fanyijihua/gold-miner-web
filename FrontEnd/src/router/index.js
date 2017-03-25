import Vue from 'vue'
import Router from 'vue-router'

import Index from '@/containers/Index'
import Recommend from '@/containers/Recommend'
import JoinUs from '@/containers/JoinUs'
import Auth from '@/containers/Auth'

Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/',
      name: 'Index',
      component: Index,
      meta: {
        title: '掘金翻译计划',
      },
    },
    {
      path: '/Recommend',
      name: 'Recommend',
      component: Recommend,
      meta: {
        title: '推荐文章',
      },
    },
    {
      path: '/joinus',
      component: JoinUs.Base,
      meta: {
        title: '加入我们',
      },
      children: [
        {
          path: '',
          name: 'JoinUs',
          component: JoinUs.Join,
          meta: {
            title: '加入我们',
          },
        },
        {
          path: 'users',
          name: 'JoinUsUsers',
          component: JoinUs.JoinUsUsers,
          meta: {
            title: '加入我们',
          },
        },
        {
          path: 'users/:id',
          name: 'JoinUsUser',
          component: JoinUs.JoinUsUser,
          meta: {
            title: '加入我们',
          },
        },
      ],
    },
    {
      path: '/',
      name: 'Auth',
      component: Auth.Base,
      children: [
        {
          path: 'auth/logout',
          name: 'Logout',
          component: Auth.Logout,
        },
      ],
    },
  ],
})

router.afterEach(route => (
  document.title = route.meta.title || '掘金翻译计划'
))

export default router
