import { defineStore } from 'pinia'
import api from '../api/axios'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('auth_token') || null,
        role: localStorage.getItem('role') || null,
    }),
    actions: {
        async login(email, password) {
            try {
                const res = await api.post('/login', { email, password })
                this.token = res.data.access_token
                const userRes = await api.get('/user', {
                    headers: { Authorization: `Bearer ${this.token}` }
                })
                this.user = userRes.data
                this.role = userRes.data.role
                localStorage.setItem('auth_token', this.token)
                localStorage.setItem('role', this.role)
                console.log('Login successful', this.user)
            } catch (err) {
                throw err
            }
        },

        logout() {
            this.user = null
            this.token = null
            this.role = null
            localStorage.removeItem('auth_token')
            localStorage.removeItem('role')
        },

        isAdmin() {
            return this.role === 'admin'
        },

        isLoggedIn() {
            return !!this.token
        }
    }
})