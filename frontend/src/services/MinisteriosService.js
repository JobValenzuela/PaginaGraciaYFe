import axios from "axios"

export default {
    get() {
        return axios.get('/ministerios')
    },
    post(data) {
        return axios.post('/ministerios',data)
    },
    put(data,id) {
        return axios.put(`/ministerios/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/ministerios/${id}`)
    },
}