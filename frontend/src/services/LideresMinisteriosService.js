import axios from "axios"

export default {
    get() {
        return axios.get('/lideres/ministerios')
    },
    post(data) {
        return axios.post('/lideres/ministerios',data)
    },
    put(data,id) {
        return axios.put(`/lideres/ministerios/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/lideres/ministerios/${id}`)
    },
}