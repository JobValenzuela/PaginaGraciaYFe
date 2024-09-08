<script setup>
import { reactive, ref } from "vue"
import { required } from '@/Utils/Rules'
import router from '@/router';
import authService from '@/services/authService';
import userStore from '@/stores/UserStore';

const loginData = reactive({
    user: '',
    pass: ''
})
const form = ref(null)
const showPassword = ref(false)
const loading = ref(false)
const UserStore = userStore()

const login = async () => {
    const { valid } = await form.value.validate()
    if (!valid) return

    try {
        loading.value = true
        const response = await authService.login(loginData)
        UserStore.createUserData(response.data.dataset)

        router.push({ name: 'dashboard' })
    } catch (e) {
        console.log(e)
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <v-app theme="light" class="gradient-background">
        <v-main class="d-flex justify-center align-center">
            <v-container fluid>
                <v-card elevation="10" flat max-width="500" class="mx-auto bg-primary my-5 pt-8 card-elevated"
                    color="transparent">
                    <v-row class="d-flex justify-center mb-4">
                        <!-- <v-col cols="12" md="6" class="d-flex justify-center align-center"> -->
                        <!-- </v-col> -->
                        <v-col>
                            <div class="d-flex justify-center">
                                <img src="/Logo.png" alt="Logo de la aplicación" height="190" class="" />
                            </div>
                            <v-card flat class="d-flex flex-column justify-center pa-4 mx-8" color="primary">
                                <!-- <v-card-title class="text-center text-h4">
                                        Iniciar sesión
                                    </v-card-title> -->


                                <v-form @submit.prevent="login" ref="form" class="mt-4">
                                    <v-text-field v-model="loginData.user" label="Usuario" prepend-icon="mdi-account"
                                        :rules="required">
                                    </v-text-field>

                                    <v-text-field v-model="loginData.pass" class="mt-3" label="Contraseña"
                                        :type="showPassword ? 'text' : 'password'" prepend-icon="mdi-lock"
                                        :rules="required" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                        @click:append="showPassword = !showPassword">
                                    </v-text-field>

                                    <v-btn :loading="loading" class="mt-5 py-5 text-subtitle-1" color="#5038b2" block
                                        type="submit">
                                        Iniciar sesión
                                    </v-btn>
                                </v-form>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>

<style scoped>
.gradient-background {
    background: linear-gradient(to bottom, rgb(222, 222, 222), #5038b2);
    min-height: 100vh;
}

.card-elevated {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    border-radius: 15px;
}

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
