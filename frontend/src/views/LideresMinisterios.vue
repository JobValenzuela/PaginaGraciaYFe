<script setup>
import { ref, onMounted } from "vue"
import PrincipalLayout from '@/components/General/PrincipalLayout.vue';
import { maxLength, required } from "@/Utils/Rules";
import { showDialog } from '@/Utils/Dialogs'
import LideresMinisteriosService from "@/services/LideresMinisteriosService";
import MiembrosService from "@/services/MiembrosService";
import CatalogoMinisteriosService from "@/services/CatalogoMinisteriosService";

// Definir variables reactivas
const search = ref('')
const dialog = ref(false)
const isEdit = ref(false)
const lideres = ref([])
const miembros = ref([])
const ministerios = ref([])
const loading = ref(false)
const loadingDialog = ref(false)
const lider = ref({})
const tab = ref(null)
const form = ref(null)

const headers = [
    { title: 'Nombre del líder', key: 'nombre_miembro', align: 'center' },
    { title: 'Nombre del ministerio', key: 'nombre_ministerio', align: 'center' },
    { title: 'Fecha en que comenzo', key: 'fecha_inicio', align: 'center' },
    { title: 'Fecha en que termino', key: 'fecha_termino', align: 'center' },
    { title: 'Acciones', key: 'acciones', align: 'center' },
]

onMounted(() => {
    loadLideres()
})

const loadLideres = async () => {
    try {
        loading.value = true
        const response = await LideresMinisteriosService.get()
        lideres.value = await response.data.dataset
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
        const message = e.response?.data?.message || 'Error cargando miembros'
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
const openDialog = (item) => {
    loadMinisterios()
    loadMiembros()
    if (item) {
        lider.value = { ...item }
        isEdit.value = true
        dialog.value = true
    } else {
        lider.value = {}
        isEdit.value = false
        dialog.value = true
    }
}

// Método para crear o editar líder de ministerio
const postOrPutLider = async () => {
    const { valid } = await form.value.validate()
    if (!valid) return
    try {
        loadingDialog.value = true
        console.log(lider.value);
        
        if (lider.value.id_lider) {
            await LideresMinisteriosService.put(lider.value, lider.value.id_lider)
            showDialog('success', 'Líder actualizado correctamente')
        } else {
            await LideresMinisteriosService.post(lider.value)
            showDialog('success', 'Líder creado correctamente')
        }
        dialog.value = false
        loadLideres()
    } catch (e) {
        const message = e.response.data.message
        showDialog('error', message)
    } finally {
        loadingDialog.value = false
    }
}

const deleteLider = async (item) => {
    try {
        await LideresMinisteriosService.delete(item.id_lider)
        loadLideres()
        showDialog('success', 'Líder eliminado correctamente')
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
                    Líderes de Ministerios
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                <div>Nuevo Líder</div>
                            </v-btn>
                            <v-icon class="ms-2 text-h4" @click="loadLideres()" v-ripple>
                                mdi-refresh
                            </v-icon>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar líder" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table :items="lideres" :loading="loading" :search="search" :headers="headers"
                                class="bg-primary">
                                <template v-slot:no-data>
                                    <v-alert :value="true" type="warning" text>
                                        No se encontraron líderes
                                    </v-alert>
                                </template>
                                <template v-slot:loading>
                                    Cargando...
                                </template>
                                <template v-slot:item.acciones="{ item }">
                                    <v-icon color="secondary" class="me-3" @click="openDialog(item)">
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon color="error" class="me-3 cursor-pointer" @click="deleteLider(item)">
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
                        {{ isEdit ? 'Editar líder' : 'Nuevo líder' }}
                    </v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="">
                            <v-autocomplete label="Miembro" :items="miembros" item-title="nombre" item-value="id_miembro" v-model="lider.id_miembro"/>
                            <v-autocomplete label="Ministerio" :items="ministerios" item-title="nombre" item-value="id_ministerio" v-model="lider.id_ministerio"/>
                            <v-text-field label="Fecha de inicio" :rules="required" type="date" v-model="lider.fecha_inicio"/>
                            <v-text-field label="Fecha de termino" type="date" v-model="lider.fecha_termino"/>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-center align-center mt-n6 mb-4">
                        <v-btn class="bg-GYF2" size="large" @click="postOrPutLider()" :loading="loadingDialog"
                            :disabled="loadingDialog">
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
