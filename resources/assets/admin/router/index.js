import { createRouter, createWebHistory } from 'vue-router'
import EmailPage from '../pages/EmailPage.vue'
import { useAuthStore } from '../store/auth' // Pinia store
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import UnAuthorized from '../pages/UnAuthorized.vue'

const routes = [{
        path: '/',
        redirect: '/login', // Mặc định redirect vào login
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/emails',
        name: 'emails.index',
        component: EmailPage,
        meta: { requiresAuth: true, role: 'admin' } // Chỉ admin mới được vào
    },
    { path: '/unauthorized', name: 'unauthorized', component: UnAuthorized },
]

const router = createRouter({
    history: createWebHistory('/admin'),
    routes,
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('auth_token')
    const role = localStorage.getItem('role')
        // Nếu truy cập login hoặc register, xóa token và role
    if (to.name === 'login' || to.name === 'register') {
        localStorage.removeItem('auth_token')
        localStorage.removeItem('role')
    }
    if (to.meta.requiresAuth && !token) return next({ name: 'login' })
    if (to.meta.role && to.meta.role !== role) return next({ name: 'unauthorized' })
    next()
})




export default router