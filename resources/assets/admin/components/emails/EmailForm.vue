<template>
  <div class="email-form">
    <form @submit.prevent="submit">
      <div class="form-group">
        <label>Email</label>
        <input v-model="form.email" type="email" placeholder="example@mail.com" required />
        <div v-if="errors.email" class="error">{{ errors.email[0] }}</div>
      </div>

      <div class="form-group">
        <label>Subject</label>
        <input v-model="form.subject" type="text" placeholder="Subject" required />
        <div v-if="errors.subject" class="error">{{ errors.subject[0] }}</div>
      </div>

      <div class="form-group">
        <label>Body</label>
        <textarea v-model="form.body" placeholder="Write your message..."></textarea>
      </div>

      <div class="form-group">
        <label>Attachment</label>
        <input type="file" @change="onFile" />
      </div>

     <div class="form-actions">
  <button type="submit" class="btn-primary">
    {{ isEditing ? 'Update' : 'Send' }}
  </button>
  <button type="button" class="btn-secondary" @click="$emit('cancel')">
    Hủy
  </button>
</div>

    </form>
  </div>
</template>

<script setup>
import { reactive, watch, computed } from 'vue'
import './../../styles/email-form.scss'
const props = defineProps({ editing: Object })
const emits = defineEmits(['save','cancel'])

const form = reactive({
  email: '',
  subject: '',
  body: '',
  attachment: null
})

const errors = reactive({})
const isEditing = computed(() => !!props.editing)

// Watch props.editing
watch(() => props.editing, (v) => {
  if (v) {
    form.email = v.email || ''
    form.subject = v.subject || ''
    form.body = v.body || ''
    form.attachment = null
  } else {
    form.email = ''
    form.subject = ''
    form.body = ''
    form.attachment = null
  }
}, { immediate: true })

function onFile(e) {
  form.attachment = e.target.files[0]
}

function submit() {
  const payload = new FormData()
  payload.append('email', form.email)
  payload.append('subject', form.subject)
  payload.append('body', form.body)
  if (form.attachment) payload.append('attachment', form.attachment)

// === DEBUG: log FormData content ===
  console.log('FormData content:')
  for (let pair of payload.entries()) {
    console.log(pair[0]+ ':', pair[1])
  }
  if (isEditing.value) {
    payload.append('_method', 'PUT') 
  }


  emits('save', payload)
}
function onCancel() {
  showForm.value = false;
  editing.value = null;
  router.back(); // quay về trang trước
  // hoặc nếu muốn luôn về emails.index:
  // router.push({ name: 'emails.index' });
}

</script>
