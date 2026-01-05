import User from '@/pages/admin/Create/User.vue'
import AccountType from '@/pages/admin/Create/AccountType.vue'
import Currency from '@/pages/admin/Create/Currency.vue'
import TransactionType from '@/pages/admin/Create/TransactionType.vue'
import Login from '@/pages/auth/Login.vue'
import Logout from '@/pages/auth/Logout.vue'
import Register from '@/pages/auth/Register.vue'
import AccountTransactions from '@/pages/user/AccountTransactions.vue'
import Chat from '@/pages/user/Chat.vue'
import Favorites from '@/pages/user/Favorites.vue'
import Home from '@/pages/user/Home.vue'
import Profile from '@/pages/user/Profile.vue'
import SendMoney from '@/pages/user/SendMoney.vue'
import { createRouter, createWebHistory } from 'vue-router'
import Account from '@/pages/admin/Create/Account.vue'
import Transaction from '@/pages/admin/Create/Transaction.vue'
import Currencies from '@/pages/admin/Lists/Currencies.vue'
import CurrencyUpdate from '@/pages/admin/Update/CurrencyUpdate.vue'
import AccountTypes from '@/pages/admin/Lists/AccountTypes.vue'
import AccountTypeUpdate from '@/pages/admin/Update/AccountTypeUpdate.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/login', component: Login },
    { path: '/register', component: Register},
    { path: '/', component: Home },
    { path: '/profile', component: Profile },
    { path: '/logout', component: Logout },
    { path: '/favorites', component: Favorites },
    { path: '/chat/:id', name: 'users.chat', component: Chat, props: true },
    { path: '/send-money', component: SendMoney, props: true },
    { path: '/account/:id/transactions', name: 'account.trasnactions' , component: AccountTransactions, props: true },
    { path: '/currency', component: Currency},
    { path: '/account-type', component: AccountType },
    { path: '/transaction-type', component: TransactionType },
    { path: '/user', component: User },
    { path: '/account', component: Account },
    { path: '/transaction', component: Transaction },
    { path: '/currencies', component: Currencies},
    { path: '/currency/:id', name: 'currency.update', component: CurrencyUpdate, props: true},
    { path: '/account-types', component: AccountTypes },
    { path: '/account-type/:id', name: 'account_type.update', component: AccountTypeUpdate, props: true}
  ],
})

export default router
