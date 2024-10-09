import axios from "axios"

export default {
    get() {
        return axios.get('/visitantes')
    },
    post(data) {
        return axios.post('/visitantes',data)
    },
    convertir(data) {
        return axios.post('/convertir/visitantes',data)
    },
    put(data,id) {
        return axios.put(`/visitantes/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/visitantes/${id}`)
    },
}