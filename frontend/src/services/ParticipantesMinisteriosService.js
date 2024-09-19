import axios from "axios"

export default {
    get() {
        return axios.get('/participantes/ministerios')
    },
    post(data) {
        return axios.post('/participantes/ministerios',data)
    },
    put(data,id) {
        return axios.put(`/participantes/ministerios/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/participantes/ministerios/${id}`)
    },
}