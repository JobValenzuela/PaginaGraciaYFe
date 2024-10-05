import axios from "axios"

export default {
    get() {
        return axios.get('/peticiones')
    },
    post(data) {
        return axios.post('/peticiones',data)
    },
    put(data,id) {
        return axios.put(`/peticiones/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/peticiones/${id}`)
    },
}