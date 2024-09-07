<script setup>
import UserStore from '@/stores/UserStore';
import { ref } from 'vue';
import router from '@/router';
const userStore = UserStore()
const drawer = ref(false)
const changeTheme = () => {
    userStore.modo = !userStore.modo
}
const destroySession = () => {
    userStore.destroy()
    router.push({ name: 'login' })
}
</script>


<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" app temporary>
            <v-list-item class="py-5">
                <v-icon>mdi-account</v-icon> <span class="ms-5">{{ userStore.user.user }}</span>
            </v-list-item>
            <v-divider></v-divider>
            <v-list density="compact" nav>
                <v-list-item prepend-icon="mdi-view-dashboard" title="Home" value="home"></v-list-item>
                <v-list-item prepend-icon="mdi-forum" title="About" value="about"></v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app color="primary">
                <v-btn @click="drawer = !drawer">
                    <v-icon>mdi-menu</v-icon> <span class="ms-4">Cobranza</span>
                </v-btn>
            <v-app-bar-title class="text-center ms-n16">
                <v-icon>mdi-account</v-icon> <span>{{ userStore.user.user }}</span>
            </v-app-bar-title>
            <v-menu :close-on-content-click="false" location="bottom">
                <template v-slot:activator="{ props }">
                    <div class="me-4">
                        <v-icon class="ms-n4 mt-n1" v-bind="props" color="secondary">mdi-menu-down</v-icon>
                    </div>
                </template>
                <v-card min-width="300">
                    <v-list>
                        <v-list-item v-ripple class="cursor-pointer no-select" @click="changeTheme">
                            Cambiar tema
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item v-ripple class="cursor-pointer no-select" @click="destroySession">
                            Cerrar sesión
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>
        </v-app-bar>
    </v-app>
</template>
