import { defineStore } from 'pinia';
import emailApi from '../api/emailApi';

export const useEmailStore = defineStore('email', {
    state: () => ({
        emails: []
    }),
    actions: {
        async fetchEmails() {
            const res = await emailApi.getAll();
            this.emails = res.data.data; // lấy đúng mảng emails từ resource collection
            return this.emails; // trả về mảng emails
        },
        async addEmail(payload) {
            const res = await emailApi.create(payload);
            this.emails.push(res.data);
        },
        async updateEmail(id, payload) {
            try {
                // DEBUG: log FormData trước khi gửi
                for (let pair of payload.entries()) {
                    console.log('Sending updateEmail:', pair[0], pair[1]);
                }

                const res = await emailApi.update(id, payload);
                const index = this.emails.findIndex(e => e.id === id);
                if (index !== -1) this.emails[index] = res.data;
            } catch (err) {
                if (err.response) {
                    console.error('Backend validation errors:', err.response.data);
                } else {
                    console.error('Error updating email:', err);
                }
                throw err;
            }
        },
        async deleteEmail(id) {
            await emailApi.remove(id);
            this.emails = this.emails.filter(e => e.id !== id);
        },
        async retryEmail(id) {
            await emailApi.retry(id);
            await this.fetchEmails();
        }
    }
});