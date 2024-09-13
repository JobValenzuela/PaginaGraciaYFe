<script setup>
import { ref, onMounted } from "vue"
import PrincipalLayout from '@/components/General/PrincipalLayout.vue';
import InformacionPersonal from "@/components/Miembros/InformacionPersonal.vue";
import FechasImportantes from "@/components/Miembros/FechasImportantes.vue";
import DiscipuladoJuan from "@/components/Miembros/DiscipuladoJuan.vue";
import HaciaLaMeta1 from "@/components/Miembros/HaciaLaMeta1.vue";
import HaciaLaMeta2 from "@/components/Miembros/HaciaLaMeta2.vue";
import MiembrosService from '@/services/MiembrosService'
import { useMiembroStore } from '@/stores/MiembroStore';
import { storeToRefs } from 'pinia'
import { showConfirmDialog, showDialog } from "@/Utils/Dialogs";
const MiembroStore = useMiembroStore()
const { miembro, loading } = storeToRefs(MiembroStore)

const search = ref('')
const dialog = ref(false)
const isEdit = ref(false)
const miembros = ref([])
const tab = ref()

const headers = [
    { title: 'Nombre del ministerio', key: 'nombre', align: 'center' },
    { title: 'Celular', key: 'celular', align: 'center' },
    { title: 'Fecha de nacimiento', key: 'fecha_nacimiento', align: 'center' },
    { title: 'Acciones', key: 'acciones', align: 'center' },
]

onMounted(() => {
    loadMiembros()
})

const loadMiembros = async () => {
    try {
        loading.value = true
        const response = await MiembrosService.get()
        miembros.value = await response.data.dataset
    } catch (e) {
        console.log(e);
        const message = e.response?.data?.message || 'Error cargando miembros'
        showDialog('error', message)
    } finally {
        loading.value = false
    }
}

// Abrir el diálogo para nuevo o editar
const openDialog = (item) => {
    if (item) {
        miembro.value = { ...item }
        isEdit.value = true
    } else {
        miembro.value = {}
        isEdit.value = false
    }
    dialog.value = true
}

const deleteMiembros = async (item) => {
    try {
        const confirm = await showConfirmDialog("¿Seguro?","¿Estas seguro de que quieres eliminarlo?")
        if(confirm){
            await MiembrosService.delete(item.id_miembro)
            loadMiembros()
            showDialog('success', 'Miembro eliminado correctamente')
        }
    } catch (e) {
        const message = e.response?.data?.message || 'Error eliminando miembro'
        showDialog('error', message)
    }
}

const enviarInformacion = async () => {
    try {
        loading.value = true
        const response = await MiembroStore.enviarInformacion()
        const message = miembro.value.id_miembro ? "Miembro actualizado correctamente" : "Miembro creado con exito"
        showDialog('success', message)
        loadMiembros()
        dialog.value = false
    } catch (e) {
        const message = e.response?.data?.message || 'Error eliminando miembro'
        showDialog('error', message)
    }finally{
        loading.value = false
    }
}

</script>

<template>
    <PrincipalLayout>
        <div>
            <v-card class="bg-primary" elevation="24" rounded="xl">
                <v-card-title class="text-h4 text-center mt-3">
                    Miembros
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                Nuevo miembro
                            </v-btn>
                            <v-icon class="ms-2 text-h4" @click="loadMiembros()" v-ripple>
                                mdi-refresh
                            </v-icon>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar Miembro" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-data-table :headers="headers" :loading="loading" :items="miembros" class="bg-primary">
                            <template v-slot:no-data>
                                <v-alert :value="true" type="warning" text>
                                    No se encontraron miembros
                                </v-alert>
                            </template>
                            <template v-slot:loading>
                                Cargando...
                            </template>
                            <template v-slot:item.acciones="{ item }">
                                <v-icon color="secondary" class="me-3" @click="openDialog(item)">
                                    mdi-pencil
                                </v-icon>
                                <v-icon color="error" class="me-3 cursor-pointer" @click="deleteMiembros(item)">
                                    mdi-delete
                                </v-icon>
                            </template>
                        </v-data-table>
                    </v-row>
                </v-card-text>
            </v-card>

            <v-dialog v-model="dialog" width="95%" persistent>
                <v-card class="bg-primary" rounded="xl">
                    <v-card-title class="text-center mt-2" :class="$vuetify.display.mobile ? 'text-h4' : 'text-h5'">
                        {{ isEdit ? 'Editar miembro' : 'Nuevo miembro' }}

                        <!-- Icono de cerrar -->
                        <v-btn icon @click="dialog = false" class="close-btn bg-primary text-h5" absolute flat>
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-tabs v-model="tab" align-tabs="center" color="deep-purple-accent-4">
                            <v-tab value="1">Informacion personal</v-tab>
                            <v-tab value="2">Fechas importantes</v-tab>
                            <v-tab value="3">Discipulado Juan</v-tab>
                            <v-tab value="4">Hacia la meta 1</v-tab>
                            <v-tab value="5">Hacia la meta 2</v-tab>
                        </v-tabs>

                        <v-tabs-window v-model="tab">
                            <v-tabs-window-item value="1">
                                <InformacionPersonal />
                            </v-tabs-window-item>
                            <v-tabs-window-item value="2">
                                <FechasImportantes />
                            </v-tabs-window-item>
                            <v-tabs-window-item value="3">
                                <DiscipuladoJuan />
                            </v-tabs-window-item>
                            <v-tabs-window-item value="4">
                                <HaciaLaMeta1 />
                            </v-tabs-window-item>
                            <v-tabs-window-item value="5">
                                <HaciaLaMeta2 />
                            </v-tabs-window-item>
                        </v-tabs-window>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn class="bg-GYF2" block size="large" @click="enviarInformacion()" rounded="xl" :loading="loading" :disabled="loading">Guardar</v-btn>
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
