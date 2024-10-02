import { ref } from 'vue';
import { defineStore } from 'pinia';
import axios from 'axios';

export default defineStore('UserStore', () => {
    const user = ref({
        token: '',
        nombre_usuario: '',
        id: 0,
        isLogged: false,
        isAdmin: false
    });
    const modo = ref(true);

    const loadUserData = () => {
        const local = localStorage.getItem('user');

        if (local) {
            user.value = JSON.parse(local);
            user.value.isLogged = true;

            axios.defaults.headers.common["API-KEY"] = user.value.token;
        }
    };

    const editUserData = (data) => {
        user.value.nombre_completo = data.nombre_completo;
        user.value.nombre_usuario = data.nombre_usuario;
        user.value.imagen = data.imagen;
    };

    const createUserData = (data) => {
        user.value = data;
        user.value.isLogged = true;
        axios.defaults.headers.common["API-KEY"] = user.value.token;
        localStorage.setItem('user', JSON.stringify(data));
    };

    const destroy = () => {
        user.value = {
            token: '',
            user: '',
            id: 0,
            isLogged: false,
            isAdmin: false
        };

        axios.defaults.headers.common["API-KEY"] = '';
    };

    return {
        user,
        loadUserData,
        createUserData,
        editUserData,
        destroy,
        modo
    };
}, {
    persist: {
        key: 'user-store',
        storage: localStorage,
        paths: ['user', 'modo']
    }
});
