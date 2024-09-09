import { ref } from 'vue';
import { defineStore } from 'pinia';
import axios from 'axios';

export const useMiembroStore = defineStore('miembro', () => {
    const miembro = ref({});

    return {
        miembro
    };
});
