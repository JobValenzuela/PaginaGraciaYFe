import axios from "axios"

export default {
    get() {
        return axios.get('/IngresosEgresos')
    },
    post(data) {
        return axios.post('/IngresosEgresos',data)
    },
    put(data,id) {
        return axios.put(`/IngresosEgresos/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/IngresosEgresos/${id}`)
    },
}