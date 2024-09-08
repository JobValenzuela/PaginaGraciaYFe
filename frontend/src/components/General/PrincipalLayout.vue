            <script setup>
            import { ref, onMounted } from 'vue'
            import { useRouter, useRoute } from 'vue-router'
            import UserStore from '@/stores/UserStore'

            const userStore = UserStore()
            const router = useRouter()
            const currentRoute = useRoute()
            const routes = router.options.routes
            const drawer = ref(true)
            const rail = ref(true)
            const routesFilter = ref([])

            onMounted(() => {
                routesFilter.value = routes.filter((route) => {
                    return route.meta && route.meta.isAuth === true
                })
            })

            const toggleTheme = () => {
                userStore.modo = !userStore.modo
            }

            const destroy = () => {
                // lógica para cerrar sesión
            }
</script>
<template>
    <v-app :theme="userStore.modo ? 'light' : 'dark'" class="bg-primary">
        <v-app-bar color="GYF2" elevation="2">
            <template v-slot:prepend class="d-flex justify-center">
                <v-app-bar-nav-icon @click.stop="rail = !rail"></v-app-bar-nav-icon>
                <div class="ms-4">
                    Iglesia Gracia y Fe
                </div>
            </template>
            <v-toolbar-title class="text-center text-h5">
            </v-toolbar-title>
            <template v-slot:append>
                <v-menu>
                    <template v-slot:activator="{ props }">
                        <!-- Botón para abrir el menú -->
                        <v-btn v-bind="props">
                            <div class="d-flex">
                                <div>
                                    {{ userStore.user.nombre_completo }}
                                </div>
                                <div>
                                    <v-icon>mdi-chevron-down</v-icon>

                                </div>
                            </div>
                        </v-btn>
                    </template>

                    <!-- Opciones del menú -->
                    <v-card max-width="400" rounded="lg">
                        <v-list-item @click="toggleTheme">
                            <div class="d-flex my-2 mx-3">
                                <div>
                                    <v-icon left>mdi-theme-light-dark</v-icon>
                                </div>
                                <div class="ms-4">
                                    <v-list-item-title>Cambiar tema</v-list-item-title>
                                </div>
                            </div>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item @click="destroy">
                            <div class="d-flex my-2 mx-3">
                                <div>
                                    <v-icon left>mdi-logout-variant</v-icon>
                                </div>
                                <div class="ms-4">
                                    <v-list-item-title>Cerrar Sesión</v-list-item-title>
                                </div>
                            </div>
                        </v-list-item>
                    </v-card>
                </v-menu>
            </template>



        </v-app-bar>

        <v-navigation-drawer v-model="drawer" :rail="rail" class="bg-primary" border="none" elevation="12">
            <v-list>
                <v-list-item v-for="(route, index) in routesFilter" :key="index"
                    :class="{ 'bg-GYF2': currentRoute.name === route.name }" @click="$router.push(route.path)">
                    <div class="d-flex">
                        <div>
                            <v-icon left>{{ route.meta.icon }}</v-icon>
                        </div>
                        <div class="ms-4">
                            <v-list-item-title>{{ route.meta.nombrePublico || route.name }}</v-list-item-title>
                        </div>
                    </div>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-main class=" mx-6 my-2">
            <!-- Aquí renderizamos el contenido pasado al layout -->
            <slot></slot>
        </v-main>
    </v-app>
</template>


<style>
.bg-light-blue {
    background-color: #90caf9 !important;
}

.bg-GYF {
    background-color: #42a5f5 !important;
    /* Estilo de fondo para la clase bg-GYF */
}
</style>