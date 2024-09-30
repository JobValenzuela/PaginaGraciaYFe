<template>
    <PrincipalLayout>
        <div>
            <!-- Card Principal -->
            <v-card class="bg-primary" elevation="24" rounded="xl">
                <v-card-title class="text-h4 text-center mt-3">
                    Consejerías
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                <div>Nueva consejería</div>
                            </v-btn>
                            <v-icon class="ms-2 text-h4" @click="loadConsejerias()" v-ripple>
                                mdi-refresh
                            </v-icon>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar consejería" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table :items="consejerias" :loading="loading" :search="search" :headers="headers"
                                class="bg-primary">
                                <template v-slot:no-data>
                                    <v-alert :value="true" type="warning" text>
                                        No se encontraron consejerías
                                    </v-alert>
                                </template>
                                <template v-slot:loading>
                                    Cargando...
                                </template>
                                <template v-slot:item.acciones="{ item }">
                                    <v-icon color="secondary" class="me-3" @click="openDialog(item)">
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon color="error" class="me-3 cursor-pointer" @click="deleteConsejeria(item)">
                                        mdi-delete
                                    </v-icon>
                                </template>
                            </v-data-table>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <!-- Dialogo para crear/editar consejería -->
            <v-dialog v-model="dialog" max-width="700px">
                <v-card class="bg-primary" rounded="xl">
                    <v-card-title class="text-center mt-2" :class="$vuetify.display.mobile ? 'text-h4' : 'text-h5'">
                        {{ isEdit ? 'Editar consejería' : 'Nueva consejería' }}
                    </v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="">
                            <!-- Campo de descripción con validaciones -->
                            <v-text-field label="Descripción de la consejería" v-model="consejeria.descripcion"
                                prepend-inner-icon="mdi-text me-2" :rules="[required, maxLength(255)].flat()" />

                            <!-- Campo de fecha de inicio con validaciones -->
                            <v-text-field label="Fecha de inicio" v-model="consejeria.fecha_inicio"
                                prepend-inner-icon="mdi-calendar" :rules="[required]" type="date" class="mb-3" />

                            <!-- Campo de fecha de fin con validaciones -->
                            <v-text-field label="Fecha de fin (opcional)" v-model="consejeria.fecha_fin"
                                prepend-inner-icon="mdi-calendar" type="date" class="mb-3" />

                            <!-- Campo de hora con validaciones -->
                            <v-text-field label="Hora de la consejería (opcional)" v-model="consejeria.hora_consejeria"
                                prepend-inner-icon="mdi-clock"
                                :rules="[{ regex: /^[0-9]{1,2}:[0-9]{2}$/, message: 'Formato de hora inválido' }].flat()"
                                type="time" class="mb-3" />

                            <!-- Campo de lugar con validaciones -->
                            <v-text-field label="Lugar de la consejería (opcional)"
                                v-model="consejeria.lugar_consejeria" prepend-inner-icon="mdi-map-marker"
                                :rules="[maxLength(255)].flat()" class="mb-3" />

                            <!-- Campo de selección para el miembro encargado -->
                            <v-autocomplete label="Miembro encargado" v-model="consejeria.id_miembro" :items="miembros"
                                item-title="nombre" item-value="id_miembro" :rules="[required].flat()" />
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-center align-center mt-n6 mb-4">
                        <v-btn class="bg-GYF2" size="large" @click="postOrPutConsejeria()" :loading="loadingDialog"
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

.swal2-container {
    z-index: 999999 !important;
}
</style>

<script setup>
import { ref, onMounted } from "vue";
import PrincipalLayout from '@/components/General/PrincipalLayout.vue';
import { maxLength, required } from "@/Utils/Rules";
import ConsejeriaService from "@/services/ConsejeriaService"; // Cambiado a ConsejeriaService
import MiembrosService from "@/services/MiembrosService";
import { showDialog } from '@/Utils/Dialogs';

// Definir variables reactivas
const search = ref('');
const dialog = ref(false);
const isEdit = ref(false);
const consejerias = ref([]); // Cambiado a consejerías
const miembros = ref([]);
const loading = ref(false);
const loadingDialog = ref(false);
const consejeria = ref({}); // Cambiado a consejería
const tab = ref(null);
const form = ref(null);

const headers = [
    { title: 'Miembro encargado', key: 'nombre', align: 'center' },
    { title: 'Fecha de inicio', key: 'fecha_inicio', align: 'center' },
    { title: 'Descripción', key: 'descripcion', align: 'center' },
    { title: 'Lugar', key: 'lugar_consejeria', align: 'center' },
    { title: 'Hora', key: 'hora_consejeria', align: 'center' },
    { title: 'Fecha de termino', key: 'fecha_fin', align: 'center' },
    { title: 'Acciones', key: 'acciones', align: 'center' },
];

onMounted(() => {
    loadConsejerias();
    loadMiembros(); // Cargar los miembros al montar el componente
});

const loadConsejerias = async () => { // Cambiado a loadConsejerias
    try {
        loading.value = true;
        const response = await ConsejeriaService.get(); // Cambiado a ConsejeriaService
        consejerias.value = await response.data.dataset;
    } catch (e) {
        const message = e.response?.data?.message || 'Error cargando consejerías';
        showDialog('error', message);
    } finally {
        loading.value = false;
    }
};

const loadMiembros = async () => {
    try {
        loading.value = true;
        const response = await MiembrosService.get();
        miembros.value = await response.data.dataset;
    } catch (e) {
        const message = e.response?.data?.message || 'Error cargando miembros';
        showDialog('error', message);
    } finally {
        loading.value = false;
    }
};

// Abrir el diálogo para nueva o editar consejería
const openDialog = (item) => {
    if (item) {
        consejeria.value = { ...item };
        isEdit.value = true;
        dialog.value = true;
    } else {
        consejeria.value = {};
        isEdit.value = false;
        dialog.value = true;
    }
};

// Método para crear o editar consejería
const postOrPutConsejeria = async () => { // Cambiado a postOrPutConsejeria
    const { valid } = await form.value.validate();
    if (!valid) return;

    try {
        loadingDialog.value = true;
        if (consejeria.value.id_consejeria) { // Cambiado a consejería
            await ConsejeriaService.put(consejeria.value, consejeria.value.id_consejeria);
            showDialog('success', 'Consejería actualizada correctamente');
        } else {
            await ConsejeriaService.post(consejeria.value);
            showDialog('success', 'Consejería creada correctamente');
        }
        dialog.value = false;
        loadConsejerias();
    } catch (e) {
        const message = e.response?.data?.message || 'Error al guardar consejería';
        showDialog('error', message);
    } finally {
        loadingDialog.value = false;
    }
};

const deleteConsejeria = async (item) => { // Cambiado a deleteConsejeria
    try {
        await ConsejeriaService.delete(item.id_consejeria); // Cambiado a consejería
        loadConsejerias();
        showDialog('success', 'Consejería eliminada correctamente');
    } catch (e) {
        const message = e.response?.data?.message || 'Error al eliminar consejería';
        showDialog('error', message);
    }
};
</script>