import Login from '@/pages/auth/Login.vue'
import Logout from '@/pages/auth/Logout.vue'
import AccountTransactions from '@/pages/user/AccountTransactions.vue'
import Chat from '@/pages/user/Chat.vue'
import Favorites from '@/pages/user/Favorites.vue'
import Home from '@/pages/user/Home.vue'
import Profile from '@/pages/user/Profile.vue'
import SendMoney from '@/pages/user/SendMoney.vue'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/login', component: Login },
    { path: '/', component: Home },
    { path: '/profile', component: Profile },
    { path: '/logout', component: Logout },
    { path: '/favorites', component: Favorites },
    { path: '/chat/:id', name: 'users.chat', component: Chat, props: true },
    { path: '/send-money', component: SendMoney, props: true },
    { path: '/account/:id/transactions', name: 'account.trasnactions' , component: AccountTransactions, props: true }
  ],
})

export default router
