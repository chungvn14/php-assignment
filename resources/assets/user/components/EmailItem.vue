<template>
  <div class="email-item">
    <div class="email-info">
      <div class="subject">{{ item.subject }}</div>
      <div class="details">
        {{ item.email }} • <span class="status" :class="item.status">{{ item.status }}</span>
      </div>
    </div>
    <div class="email-actions">
      <button class="btn-edit" @click="$emit('edit', item)">Edit</button>
      <button class="btn-delete" @click="$emit('delete', item.id)">Delete</button>
      <button
        v-if="item.status === 'failed'"
        class="btn-retry"
        @click="$emit('retry', item.id)"
      >
        Retry
      </button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  item: {
    type: Object,
    required: true
  }
});
</script>

<style scoped lang="scss">
.email-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 15px;
  border-bottom: 1px solid #e5e7eb;
  background-color: #fff;
  border-radius: 8px;
  margin-bottom: 8px;
  transition: box-shadow 0.2s;

  &:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .email-info {
    display: flex;
    flex-direction: column;

    .subject {
      font-weight: 600;
      font-size: 15px;
      margin-bottom: 3px;
    }

    .details {
      font-size: 13px;
      color: #6b7280;

      .status {
        text-transform: capitalize;
        font-weight: 500;

        &.sent { color: #10b981; }
        &.failed { color: #ef4444; }
        &.pending { color: #f59e0b; }
      }
    }
  }

  .email-actions {
    display: flex;
    gap: 6px;

    button {
      padding: 5px 12px;
      border-radius: 6px;
      font-size: 13px;
      cursor: pointer;
      font-weight: 500;
      border: none;
      transition: background 0.2s, color 0.2s;
    }

    .btn-edit {
      background-color: #3b82f6;
      color: #fff;
      &:hover { background-color: #2563eb; }
    }

    .btn-delete {
      background-color: #ef4444;
      color: #fff;
      &:hover { background-color: #dc2626; }
    }

    .btn-retry {
      background-color: #f59e0b;
      color: #fff;
      &:hover { background-color: #d97706; }
    }
  }
}
</style>
