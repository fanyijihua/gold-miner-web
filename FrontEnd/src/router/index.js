import Vue from 'vue'
import Router from 'vue-router'

import Index from '@/containers/Index'
import Recommend from '@/containers/Recommend'
import JoinUs from '@/containers/JoinUs'
import Auth from '@/containers/Auth'
import Articles from '@/containers/Articles'

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
      path: '/auth',
      name: 'Auth',
      component: Auth.Base,
      children: [
        {
          path: 'logout',
          name: 'Logout',
          component: Auth.Logout,
        },
      ],
    },
    {
      path: '/articles',
      name: 'Articles',
      component: Articles.Base,
      children: [
        {
          path: '',
          name: 'ArticleList',
          component: Articles.List,
          meta: {
            title: '文章列表',
          },
        },
        {
          path: ':id',
          name: 'ArticleItem',
          component: Articles.Item,
        },
        {
          path: ':id/details',
          name: 'ArticleDetail',
          component: Articles.Detail,
        },
        {
          path: ':id/referrals',
          name: 'ArticleReferrals',
          component: Articles.Referrals,
        },
      ],
    },
  ],
})

router.afterEach(route => (
  document.title = route.meta.title || '掘金翻译计划'
))

export default router
