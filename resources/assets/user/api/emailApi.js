import api from './axios'

export default {
    getAll(params = {}) {
        return api.get('/emails', { params })
    },
    getOne(id) {
        return api.get(`/emails/${id}`)
    },
    create(formData) {
        return api.post('/emails', formData, { headers: { 'Content-Type': 'multipart/form-data' } })
    },
    update(id, formData) {
        return api.post(`/emails/${id}?_method=PUT`, formData, { headers: { 'Content-Type': 'multipart/form-data' } })
    },
    remove(id) {
        return api.delete(`/emails/${id}`)
    },
    retry(id) {
        return api.post(`/emails/${id}/retry`)
    }
}