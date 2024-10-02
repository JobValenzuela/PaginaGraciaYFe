import axios from "axios"

export default {
    get() {
        return axios.get('/roles')
    },
    post(data) {
        return axios.post('/roles',data)
    },
    put(data,id) {
        return axios.put(`/roles/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/roles/${id}`)
    },
}