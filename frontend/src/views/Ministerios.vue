<script setup>
import { ref } from "vue"
import PrincipalLayout from '@/components/General/PrincipalLayout.vue';
import { maxLength, required } from "@/Utils/Rules";

// Definir variables reactivas
const search = ref('')
const dialog = ref(false)
const isEdit = ref(false)
const ministerios = ref([])
const loading = ref(false)
const ministerio = ref({})
const tab = ref(null)
const form = ref(null)

// Abrir el diálogo para nuevo o editar
const openDialog = (item) => {
    if (item) {
        ministerio.value = { ...item }
        isEdit.value = true
        dialog.value = true
    } else {
        ministerio.value = {}
        isEdit.value = false
        dialog.value = true
    }
}

// Método para crear o editar ministerio
const postOrPutMinisterio = () => {
    if (!form.value.validate()) {
        // Aquí se hace la acción de enviar los datos
        console.log(isEdit.value ? 'Actualizando ministerio' : 'Creando nuevo ministerio', ministerio.value)
        // Cerrar el diálogo después de enviar los datos
        dialog.value = false
    }
}
</script>

<template>
    <PrincipalLayout>
        <div>
            <!-- Card Principal -->
            <v-card class="bg-primary" elevation="24" rounded="xl">
                <v-card-title class="text-h4 text-center mt-3">
                    Ministerios
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                <div>Nuevo ministerio</div>
                            </v-btn>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar ministerio" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table :items="ministerios" :loading="loading" :search="search" class="bg-primary">
                                <template v-slot:no-data>
                                    <v-alert :value="true" type="warning" text>
                                        No se encontraron ministerios
                                    </v-alert>
                                </template>
                                <template v-slot:loading>
                                    Cargando...
                                </template>
                            </v-data-table>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <!-- Dialogo para crear/editar ministerios -->
            <v-dialog v-model="dialog" max-width="700px">
                <v-card class="bg-primary" rounded="xl">
                    <v-card-title class="text-center mt-2" :class="$vuetify.display.mobile ? 'text-h4' : 'text-h5'">
                        {{ isEdit ? 'Editar ministerio' : 'Nuevo ministerio' }}
                    </v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="postOrPutMinisterio">
                            <!-- Campo de nombre con validaciones -->
                            <v-text-field label="Nombre del ministerio" v-model="ministerio.nombre"
                                prepend-inner-icon="mdi-account me-2" :rules="[required, maxLength(60)].flat()" class="mb-3"/>
                            <!-- Campo de descripción con validaciones -->
                            <v-text-field label="Descripción" v-model="ministerio.descripcion"
                                prepend-inner-icon="mdi-text me-2" :rules="[maxLength(255)].flat()"/>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-center align-center mt-n6 mb-4">
                        <v-btn class="bg-GYF2" size="large" @click="postOrPutMinisterio">
                            {{ isEdit ? 'Guardar' : 'Crear' }}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
    </PrincipalLayout>
</template>

<style scoped>
.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
}
</style>
