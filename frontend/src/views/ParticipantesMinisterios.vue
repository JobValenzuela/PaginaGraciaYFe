<script setup>
import { ref, onMounted } from "vue"
import PrincipalLayout from '@/components/General/PrincipalLayout.vue';
import { maxLength, required } from "@/Utils/Rules";
import { showConfirmDialog, showDialog } from '@/Utils/Dialogs'
import ParticipantesMinisteriosService from "@/services/ParticipantesMinisteriosService";
import MiembrosService from "@/services/MiembrosService";
import CatalogoMinisteriosService from "@/services/CatalogoMinisteriosService";

// Definir variables reactivas
const search = ref('')
const dialog = ref(false)
const participantes = ref([])
const miembros = ref([])
const ministerios = ref([])
const loading = ref(false)
const loadingDialog = ref(false)
const participante = ref({})
const form = ref(null)

const headers = [
    { title: 'Ministerio', key: 'nombre_ministerio', align: 'center' },
    { title: 'Miembro', key: 'nombre_miembro', align: 'center' },
    { title: 'Acciones', key: 'acciones', align: 'center' },
]

onMounted(() => {
    loadParticipantes()
})

const loadParticipantes = async () => {
    try {
        loading.value = true
        const response = await ParticipantesMinisteriosService.get()
        participantes.value = await response.data.dataset
    } catch (e) {
        const message = e.response.data.message
        showDialog('error', message)
    } finally {
        loading.value = false
    }
}
const loadMiembros = async () => {
    try {
        const response = await MiembrosService.get()
        miembros.value = await response.data.dataset
    } catch (e) {
        console.log(e);
        const message = e.response?.data?.message || 'Error cargando los participantes de los ministerios'
        showDialog('error', message)
    }
}

const loadMinisterios = async () => {
    try {
        const response = await CatalogoMinisteriosService.get()
        ministerios.value = await response.data.dataset
    } catch (e) {
        const message = e.response.data.message

        showDialog('error', message)
    }
}

// Abrir el diálogo para nuevo o editar
const openDialog = async () => {
    loadingDialog.value = true
    await loadMinisterios()
    await loadMiembros()
    loadingDialog.value = false
        participante.value = {}
        dialog.value = true
}

// Método para crear o editar líder de ministerio
const postParticipante = async () => {
    const { valid } = await form.value.validate()
    if (!valid) return
    try {
        loadingDialog.value = true
            await ParticipantesMinisteriosService.post(participante.value)
            showDialog('success', 'Miembro agregado correctamente al ministerio')
        dialog.value = false
        loadParticipantes()
    } catch (e) {
        const message = e.response.data.message
        showDialog('error', message)
    } finally {
        loadingDialog.value = false
    }
}

const deleteParticipante = async (item) => {
    try {
        const confirm = await showConfirmDialog(
            'Estas seguro de eliminar este participante?',
            '',
            'warning')
        if(!confirm) return
        await ParticipantesMinisteriosService.delete(item.id_participante_ministerio)
        loadParticipantes()
        showDialog('success', 'Se quito el miembro del ministerio correctamente')
    } catch (e) {
        const message = e.response.data.message
        showDialog('error', message)
    }
}
</script>

<template>
    <PrincipalLayout>
        <div>
            <!-- Card Principal -->
            <v-card class="bg-primary" elevation="24" rounded="xl">
                <v-card-title class="text-h4 text-center mt-3">
                    Participantes ministerios
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                <div>Añadir un miembro a algun ministerio</div>
                            </v-btn>
                            <v-icon class="ms-2 text-h4" @click="loadParticipantes()" v-ripple>
                                mdi-refresh
                            </v-icon>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar miembro" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table :items="participantes" :loading="loading" :search="search" :headers="headers"
                                class="bg-primary">
                                <template v-slot:no-data>
                                    <v-alert :value="true" type="warning" text>
                                        No hay miembros añadidos en ningun ministerio
                                    </v-alert>
                                </template>
                                <template v-slot:loading>
                                    Cargando...
                                </template>
                                <template v-slot:item.acciones="{ item }">
                                    <v-icon color="secondary" class="me-3" @click="openDialog(item)">
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon color="error" class="me-3 cursor-pointer" @click="deleteParticipante(item)">
                                        mdi-delete
                                    </v-icon>
                                </template>
                            </v-data-table>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <!-- Dialogo para crear/editar líder -->
            <v-dialog v-model="dialog" max-width="700px">
                <v-card class="bg-primary" rounded="xl">
                    <v-card-title class="text-center mt-2" :class="$vuetify.display.mobile ? 'text-h4' : 'text-h5'">
                        Añadir un miembro a un ministerio
                    </v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="">
                            <v-autocomplete label="Miembro" :items="miembros" item-title="nombre" item-value="id_miembro" v-model="participante.id_miembro" :rules="required"/>
                            <v-autocomplete label="Ministerio" :items="ministerios" item-title="nombre" item-value="id_ministerio" v-model="participante.id_ministerio" :rules="required"/>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-center align-center mt-n6 mb-4">
                        <v-btn class="bg-GYF2" size="large" @click="postParticipante()" :loading="loadingDialog"
                            :disabled="loadingDialog">
                            Guardar
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

.swal2-container {
    z-index: 999999 !important;
}

</style>
