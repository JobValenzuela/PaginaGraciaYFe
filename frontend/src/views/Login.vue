<script setup>
import TopBar from '@/components/Generals/TopBarLogin.vue'
import { reactive, ref } from "vue"
import DialogHandler from '../Utils/DialogHandler'
import { required } from '@/Utils/Rules'
import router from '@/router';
import authService from '@/services/authService';
import userStore from '@/stores/UserStore';
import ResponseHandler from '../Utils/ResponseHandler'

const loginData = reactive({
    user: '',
    pass: ''
})
const form = ref(null)
const showPassword = ref(false)
const dialogHandler = new DialogHandler()
const loading = ref(false)
const UserStore = userStore()

const login = async () => {
    const { valid } = await form.value.validate()
    if (!valid) return

    try {
        loading.value = true
        const response = await authService.login(loginData)
        UserStore.createUserData(response.data.dataset)

        if (UserStore.user.isAdmin)
            router.push({ name: 'admin-dashboard' })
        else
            router.push({ name: 'user-dashboard' })
    } catch (e) {
        console.log(e)
        dialogHandler.show('error','Error en los datos proporcionados')
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <v-app :theme="userStore.modo ? 'light' : 'dark'">
        <TopBar/>
        <v-main>
            <v-container fluid>
                <v-card flat max-width="900" class="mx-auto bg-primary my-5 pt-8" color="primary">
                    <v-form class="d-flex flex-column">
                        <v-row class="d-flex justify-center mb-4">
                            <v-col cols="12" md="6" class="d-flex justify-center align-center">
                                <img src="@/assets/Sidev.png" alt="Logo de la aplicación" height="200" class=""/>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-card flat class="d-flex flex-column justify-center pa-4" color="primary">
                                    <v-card-title class="headline text-center">
                                        Iniciar sesión
                                    </v-card-title>

                                    <v-alert v-if="dialogHandler.message.value" class="mt-6 mb-n4"
                                             :text="dialogHandler.message.value" :type="dialogHandler.type.value">
                                    </v-alert>

                                    <v-form @submit.prevent="login" ref="form" class="mt-8">
                                        <v-text-field v-model="loginData.user" label="Usuario"
                                                      prepend-icon="mdi-account" :rules="required">
                                        </v-text-field>

                                        <v-text-field v-model="loginData.pass" class="mt-6" label="Contraseña"
                                                      :type="showPassword ? 'text' : 'password'" prepend-icon="mdi-lock"
                                                      :rules="required"
                                                      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                                      @click:append="showPassword = !showPassword">
                                        </v-text-field>

                                        <v-btn :loading="loading" class="mt-10 py-5 text-subtitle-1" color="botones"
                                               block type="submit">
                                            Iniciar sesión
                                        </v-btn>
                                    </v-form>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>

<style scoped>
.error-title {
    color: #e3342f !important;
}

.error-icon {
    color: #e3342f !important;
}

.error-button {
    background-color: #e3342f !important;
}

.btn-text {
    font-size: 14px;
    /* Tamaño de fuente más pequeño para pantallas más pequeñas */
}

@media (max-width: 600px) {
    .btn-text {
        font-size: 12px;
        /* Reducir el tamaño de fuente aún más para pantallas muy pequeñas */
    }
}
</style>
