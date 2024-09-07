<template>
    <div>
        <v-app :theme="userStore.modo ? 'light' : 'dark'">
            
            <TopBar/>
            <v-main>
                <slot />
            </v-main>
        </v-app>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import TopBar from './TopBar.vue'
import UserStore from '@/stores/UserStore';
const userStore = UserStore()
onMounted(async () => {
    const user = localStorage.getItem('data');
    const theme = localStorage.getItem('theme');
    UserStore.user = JSON.parse(user);
    UserStore.modo = JSON.parse(theme);
})
</script>
