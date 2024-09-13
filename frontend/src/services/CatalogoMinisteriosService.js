import axios from "axios"

export default {
    get() {
        return axios.get('/catalogo/ministerios')
    },
    post(data) {
        return axios.post('/catalogo/ministerios',data)
    },
    put(data,id) {
        return axios.put(`/catalogo/ministerios/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/catalogo/ministerios/${id}`)
    },
}