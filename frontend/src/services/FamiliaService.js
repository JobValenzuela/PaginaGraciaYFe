import axios from "axios"

export default {
    get() {
        return axios.get('/catalogo/familias')
    },
    post(data) {
        return axios.post('/catalogo/familias',data)
    },
    put(data,id) {
        return axios.put(`/catalogo/familias/${id}`,data)
    },
    delete(id) {
        return axios.delete(`/catalogo/familias/${id}`)
    },
    getMiembrosFamilia(id) {
        return axios.get(`/miembros/familias/${id}`)
    },
    addMiembrosFamilia(data) {
        return axios.post(`/miembros/familias`,data)
    },
    deleteMiembroFamilia(id) {
        return axios.delete(`/miembros/familias/${id}`)
    },
}