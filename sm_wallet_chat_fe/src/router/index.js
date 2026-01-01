import Login from '@/pages/auth/Login.vue'
import Logout from '@/pages/auth/Logout.vue'
import Home from '@/pages/user/Home.vue'
import Profile from '@/pages/user/Profile.vue'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/login', component: Login },
    { path: '/', component: Home },
    { path: '/profile', component: Profile },
    { path: '/logout', component: Logout }
  ],
})

export default router
