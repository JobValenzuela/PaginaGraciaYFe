<template>
    <PrincipalLayout>
        <div>
            <!-- Card Principal -->
            <v-card class="bg-primary" elevation="24" rounded="xl">
                <v-card-title class="text-h4 text-center mt-3">
                    Registro de Visitantes
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                <div>Nuevo visitante</div>
                            </v-btn>
                            <v-icon class="ms-2 text-h4" @click="loadVisitantes()" v-ripple>
                                mdi-refresh
                            </v-icon>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar visitante" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table :items="visitantes" :loading="loading" :search="search" :headers="headers"
                                class="bg-primary">
                                <template v-slot:no-data>
                                    <v-alert :value="true" type="warning" text>
                                        No se encontraron visitantes
                                    </v-alert>
                                </template>
                                <template v-slot:loading>
                                    Cargando...
                                </template>
                                <template v-slot:item.acciones="{ item }">
                                    <v-icon color="secondary" class="me-3" @click="openDialog(item)">
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon color="red" class="me-3 cursor-pointer" @click="marcarVisitado(item)">
                                        mdi-delete
                                    </v-icon>
                                </template>
                            </v-data-table>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <!-- Dialogo para crear/editar visitante -->
            <v-dialog v-model="dialog" max-width="700px">
                <v-card class="bg-primary" rounded="xl">
                    <v-card-title class="text-center mt-2" :class="$vuetify.display.mobile ? 'text-h4' : 'text-h5'">
                        {{ isEdit ? 'Editar visitante' : 'Nuevo visitante' }}
                    </v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="">
                            <!-- Campo de nombre completo -->
                            <v-text-field label="Nombre completo" v-model="visitante.nombre"
                                prepend-inner-icon="mdi-text me-2" :rules="[required, maxLength(70)].flat()" />
                            <v-text-field label="Teléfono" v-model="visitante.telefono" type="number"
                                prepend-inner-icon="mdi-text me-2" :rules="[maxLength(20)].flat()" />
                            <v-text-field label="Fecha de visita" v-model="visitante.fecha_visita" type="date"
                                prepend-inner-icon="mdi-calendar" :rules="[required].flat()" />
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-center align-center mt-n6 mb-4">
                        <v-btn class="bg-GYF2" size="large" @click="postOrPutVisitante()" :loading="loadingDialog"
                            :disabled="loadingDialog">
                            {{ isEdit ? 'Guardar' : 'Crear' }}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
    </PrincipalLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import PrincipalLayout from '@/components/General/PrincipalLayout.vue';
import { maxLength, required } from "@/Utils/Rules";
import VisitanteService from "@/services/VisitanteService";
import { showConfirmDialog, showDialog } from '@/Utils/Dialogs';

const search = ref('');
const dialog = ref(false);
const isEdit = ref(false);
const visitantes = ref([]);
const loading = ref(false);
const loadingDialog = ref(false);
const visitante = ref({});
const form = ref(null);

const headers = [
    { title: 'Nombre', key: 'nombre', align: 'center' },
    { title: 'Teléfono', key: 'telefono', align: 'center' },
    { title: 'Fecha de Visita', key: 'fecha_visita', align: 'center' },
    { title: 'Acciones', key: 'acciones', align: 'center' }
];

onMounted(() => {
    loadVisitantes();
});

const loadVisitantes = async () => {
    try {
        loading.value = true;
        const response = await VisitanteService.get();
        visitantes.value = await response.data.dataset;
    } catch (e) {
        const message = e.response?.data?.message || 'Error cargando los visitantes';
        showDialog('error', message);
    } finally {
        loading.value = false;
    }
};

const openDialog = (item) => {
    if (item) {
        visitante.value = { ...item };
        isEdit.value = true;
    } else {
        visitante.value = {};
        isEdit.value = false;
    }
    dialog.value = true;
};

const postOrPutVisitante = async () => {
    const { valid } = await form.value.validate();
    if (!valid) return;

    try {
        loadingDialog.value = true;
        if (visitante.value.id_visitante) {
            await VisitanteService.put(visitante.value, visitante.value.id_visitante);
            showDialog('success', 'Visitante actualizado correctamente');
        } else {
            await VisitanteService.post(visitante.value);
            showDialog('success', 'Visitante creado correctamente');
        }
        dialog.value = false;
        loadVisitantes();
    } catch (e) {
        const message = e.response?.data?.message || 'Error al guardar el visitante';
        showDialog('error', message);
    } finally {
        loadingDialog.value = false;
    }
};

const marcarVisitado = async (item) => {
    try {
        const confirm = await showConfirmDialog('Eliminar', '¿Estás seguro de eliminarlo?', 'question');
        if (!confirm) return;
        await VisitanteService.delete(item.id_visitante);
        loadVisitantes();
        showDialog('success', 'Visitante eliminado correctamente');
    } catch (e) {
        const message = e.response?.data?.message || 'Error al marcar el visitante como visitado';
        showDialog('error', message);
    }
};
</script>
