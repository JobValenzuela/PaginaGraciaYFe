import axios from "axios"

export default {
    get() {
        return axios.get('/miembros')
    },
    post(data) {
        return axios.post('/miembros',data)
    },
    put(data,id) {
        return axios.put(`/miembros/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/miembros/${id}`)
    },
}