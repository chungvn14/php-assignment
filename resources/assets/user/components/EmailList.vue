<template>
  <table class="email-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Body</th>
        <th>Attachment</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="email in emails" :key="email.id">
        <td>{{ email.id }}</td>
        <td>{{ email.email }}</td>
        <td>{{ email.subject }}</td>
        <td>{{ email.body }}</td>
        <td>
         <a v-if="email.attachment_path" :href="`/storage/${email.attachment_path}`" target="_blank">View</a>
         <span v-else>-</span>
        </td>
        <td>
          <button @click="$emit('edit', email)">Edit</button>
          <button @click="$emit('delete', email.id)">Delete</button>
          
        </td>
      </tr>
      <tr v-if="emails.length === 0">
        <td colspan="6" class="empty-state">Không có email nào.</td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
const props = defineProps({
  emails: Array
})
</script>

<style scoped>
.email-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.email-table th,
.email-table td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
}

.email-table th {
  background-color: #f3f3f3;
}

.email-table td button {
  margin-right: 5px;
  padding: 4px 8px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.email-table td button:hover {
  opacity: 0.8;
}

.empty-state {
  text-align: center;
  font-style: italic;
  color: #666;
}
</style>
