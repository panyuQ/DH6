import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('@/views/HomeView.vue'),
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/LoginView.vue'),
      meta: {
        background1: 'url(login_bgimg.jpg) center/cover no-repeat fixed',// 大背景
        background2: 'url(login_bgimg.jpg) center/cover no-repeat fixed',// 小背景（操作框）
      }
    }
  ]
})

export default router
