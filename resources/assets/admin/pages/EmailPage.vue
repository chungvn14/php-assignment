<template>
  <div class="email-page">
    <div class="header">
      <h1>Danh sách Email</h1>
      <button class="btn-primary" @click="openForm">
        Tạo Email Mới
      </button>
    </div>

    <!-- Form overlay -->
    <EmailForm
      v-if="showForm"
      :editing="editing"
      @save="onSave"
      @cancel="onCancel"
      class="email-form-overlay"
    />

    <!-- Danh sách email chỉ hiển thị khi form đóng -->
    <div class="email-list" v-show="!showForm">
      <EmailList
        :emails="store.emails"
        @edit="startEdit"
        @delete="onDelete"
        @retry="onRetry"
      />
      <p v-if="store.emails.length === 0" class="empty-state">
        Không có email nào. Tạo mới ngay!
      </p>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import EmailForm from '../components/emails/EmailForm.vue';
import EmailList from '../components/emails/EmailList.vue';
import { useEmailStore } from '../store/emailStore';
import '../styles/email-page.scss';

const store = useEmailStore();
const showForm = ref(false);
const editing = ref(null);

onMounted(async () => {
  try {
    await store.fetchEmails();
  } catch (err) {
    console.error('Error fetching emails:', err);
  }
});

// Mở form + ẩn list
function openForm() {
  showForm.value = true;
  editing.value = null;
}

// Cancel form + hiện list
function onCancel() {
  showForm.value = false;
  editing.value = null;
}

// Edit form + ẩn list
function startEdit(item) {
  editing.value = item;
  showForm.value = true;
}

// Save form + hiện lại list
async function onSave(payload) {
  try {
    if (editing.value) {
      await store.updateEmail(editing.value.id, payload);
      editing.value = null;
    } else {
      await store.addEmail(payload);
    }
    showForm.value = false; // hiện lại list
  } catch (err) {
    console.error('Error saving email:', err);
  }
}

// Delete email
async function onDelete(id) {
  if (!confirm('Delete this email?')) return;
  try {
    await store.deleteEmail(id);
  } catch (err) {
    console.error('Error deleting email:', err);
  }
}

// Retry email
async function onRetry(id) {
  try {
    await store.retryEmail(id);
  } catch (err) {
    console.error('Error retrying email:', err);
  }
}
</script>
