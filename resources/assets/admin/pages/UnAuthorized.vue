<template>
  <div class="unauthorized-page">
    <div class="unauthorized-card">
      <h1>403</h1>
      <p>Unauthorized</p>
      <span>You do not have permission to access this page.</span>
      <router-link to="/" class="btn-home">Go login page</router-link>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped lang="scss">
.unauthorized-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(135deg, #f8d7da, #f5c6cb);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

  .unauthorized-card {
    text-align: center;
    background: #fff;
    padding: 50px 40px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);

    h1 {
      font-size: 6rem;
      color: #c0392b;
      margin: 0;
    }

    p {
      font-size: 1.8rem;
      font-weight: 600;
      margin: 10px 0;
      color: #e74c3c;
    }

    span {
      display: block;
      font-size: 1rem;
      color: #555;
      margin-bottom: 20px;
    }

    .btn-home {
      display: inline-block;
      padding: 0.6rem 1.2rem;
      border-radius: 8px;
      background-color: #c0392b;
      color: #fff;
      font-weight: 600;
      text-decoration: none;
      transition: background 0.3s;

      &:hover {
        background-color: #e74c3c;
      }
    }
  }
}
</style>
