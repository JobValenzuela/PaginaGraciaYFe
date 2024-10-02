import axios from "axios"

export default {
    get() {
        return axios.get('/usuarios')
    },
    post(data) {
        return axios.post('/usuarios',data)
    },
    put(data,id) {
        return axios.put(`/usuarios/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/usuarios/${id}`)
    },
}