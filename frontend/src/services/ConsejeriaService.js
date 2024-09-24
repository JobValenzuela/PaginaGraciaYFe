import axios from "axios"

export default {
    get() {
        return axios.get('/consejerias')
    },
    post(data) {
        return axios.post('/consejerias',data)
    },
    put(data,id) {
        return axios.put(`/consejerias/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/consejerias/${id}`)
    },
}