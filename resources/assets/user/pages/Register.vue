<template>
  <div class="register-page">
    <div class="register-card">
      <h2>Register</h2>
      <form @submit.prevent="submit">
        <div class="form-group">
          <label>Name:</label>
          <input v-model="name" type="text" required />
        </div>
        <div class="form-group">
          <label>Email:</label>
          <input v-model="email" type="email" required />
        </div>
        <div class="form-group">
          <label>Password:</label>
          <input v-model="password" type="password" required />
        </div>
        <div class="form-group">
          <label>Confirm Password:</label>
          <input v-model="password_confirmation" type="password" required />
        </div>
        <div v-if="error" class="error">{{ error }}</div>
        <button type="submit" class="btn-submit">Register</button>
      </form>
      <p class="login-link">
        Already have an account? 
        <router-link to="/login">Login</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../api/axios'

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const error = ref(null)
const router = useRouter()

const submit = async () => {
  const payload = { name: name.value, email: email.value, password: password.value, password_confirmation: password_confirmation.value }
  console.log('Register payload:', payload)
  try {
    const res = await api.post('/register', payload)
    console.log('Register response:', res.data)
    localStorage.setItem('auth_token', res.data.access_token)
    router.push({ name: 'emails.index' })
  } catch (err) {
    console.error('Register error:', err.response?.data || err)
    error.value = err.response?.data?.message || 'Register failed'
  }
}
</script>

<style scoped lang="scss">
.register-page {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
     background: linear-gradient(14deg, #627bec, #c5abdf);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

  .register-card {
    background: #fff;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 400px;
    text-align: center;

    h2 {
      margin-bottom: 25px;
      color: #333;
      font-size: 2rem;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      text-align: left;
      margin-bottom: 15px;

      label {
        margin-bottom: 5px;
        font-weight: 600;
        color: #555;
      }

      input {
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 1rem;
        transition: border 0.3s;

        &:focus {
          outline: none;
          border-color: #2575fc;
        }
      }
    }

    .error {
      color: red;
      margin-bottom: 10px;
      font-weight: 600;
      text-align: center;
    }

    .btn-submit {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background-color: #2575fc;
      color: #fff;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s;

      &:hover {
        background-color: #6a11cb;
      }
    }

    .login-link {
      margin-top: 20px;
      font-size: 0.95rem;
      color: #555;

      a {
        color: #2575fc;
        font-weight: 600;
        text-decoration: none;

        &:hover {
          text-decoration: underline;
        }
      }
    }
  }
}
</style>
