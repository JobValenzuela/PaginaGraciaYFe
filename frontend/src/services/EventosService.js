import axios from "axios"

export default {
    get() {
        return axios.get('/eventos')
    },
    post(data) {
        return axios.post('/eventos',data)
    },
    put(data,id) {
        return axios.put(`/eventos/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/eventos/${id}`)
    },
}