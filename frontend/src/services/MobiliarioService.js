import axios from "axios"

export default {
    get() {
        return axios.get('/mobiliario')
    },
    post(data) {
        return axios.post('/mobiliario',data)
    },
    put(data,id) {
        return axios.put(`/mobiliario/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/mobiliario/${id}`)
    },
}