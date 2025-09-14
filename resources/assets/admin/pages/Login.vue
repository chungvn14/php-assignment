<template>
  <div class="login-container">
    <div class="login-card">
      <h2 class="title">Welcome admin</h2>
      <form @submit.prevent="submit">
        <div class="form-group">
          <label>Email</label>
          <input v-model="email" type="email" placeholder="Enter your email" required />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input v-model="password" type="password" placeholder="Enter your password" required />
        </div>
        <div v-if="error" class="error">{{ error }}</div>
        <button type="submit">Login</button>
      </form>
      <!-- <div class="register-link">
        Don't have an account? <router-link to="/register">Register</router-link>
      </div> -->
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../store/auth'
import '../styles/login.scss'

const email = ref('')
const password = ref('')
const error = ref(null)
const router = useRouter()
const auth = useAuthStore()

const submit = async () => {
  error.value = null
  try {
    await auth.login(email.value, password.value)
    console.log('Login successful', auth.user)
    router.push({ name: 'emails.index' })
  } catch (err) {
    error.value = err.response?.data?.message || 'Login failed'
    console.error('Login error:', err)
  }
}
</script>
