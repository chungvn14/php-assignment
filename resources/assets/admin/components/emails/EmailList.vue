<template>
  <div class="email-list-table">
    <table>
      <thead>
        <tr>
          <th>Email</th>
          <th>Subject</th>
          <th>Body</th>
          <th>Attachment</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in emails" :key="item.id">
          <td>{{ item.email }}</td>
          <td>{{ item.subject }}</td>
          <td>{{ item.body }}</td>
          <td>
            <a v-if="item.attachment_path" :href="item.attachment_path" target="_blank">View</a>
          </td>
          <td>{{ item.status }}</td>
          <td>
            <button @click="$emit('edit', item)">Edit</button>
            <button @click="$emit('delete', item.id)">Delete</button>
            <button v-if="item.status === 'failed'" @click="$emit('retry', item.id)">Retry</button>
          </td>
        </tr>
        <tr v-if="emails.length === 0">
          <td colspan="6" class="empty">Không có email nào.</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
const props = defineProps({
  emails: {
    type: Array,
    default: () => []
  }
})
const emits = defineEmits(['edit', 'delete', 'retry'])
</script>

<style scoped lang="scss">
.email-list-table {
  max-width: 1000px;
  margin: 0 auto;
  overflow-x: auto;

  table {
    width: 100%;
    border-collapse: collapse;

    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #f3f4f6;
    }

    tr:nth-child(even) {
      background-color: #f9fafb;
    }

    .empty {
      text-align: center;
      padding: 20px;
      color: #6b7280;
    }

    button {
      margin-right: 5px;
      padding: 5px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      opacity: 0.8;
    }
  }
}
</style>
