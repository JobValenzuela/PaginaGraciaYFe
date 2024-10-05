<template>
    <PrincipalLayout>
        <div>
            <!-- Card Principal -->
            <v-card class="bg-primary" elevation="24" rounded="xl">
                <v-card-title class="text-h4 text-center mt-3">
                    Peticiones de oración
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                <div>Nueva peticion</div>
                            </v-btn>
                            <v-icon class="ms-2 text-h4" @click="loadPeticiones()" v-ripple>
                                mdi-refresh
                            </v-icon>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar peticion" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table :items="peticiones" :loading="loading" :search="search" :headers="headers"
                                class="bg-primary">
                                <template v-slot:no-data>
                                    <v-alert :value="true" type="warning" text>
                                        No se entontraron peticiones
                                    </v-alert>
                                </template>
                                <template v-slot:loading>
                                    Cargando...
                                </template>
                                <template v-slot:item.acciones="{ item }">
                                    <v-icon color="secondary" class="me-3" @click="openDialog(item)">
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon color="green" class="me-3 cursor-pointer" @click="marcarListo(item)">
                                        mdi-check-all
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
                        {{ isEdit ? 'Editar peticion' : 'Nueva peticion' }}
                    </v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="">
                            <!-- Campo de descripción con validaciones -->
                            <v-text-field label="Nombre completo" v-model="peticion.nombre_completo"
                                prepend-inner-icon="mdi-text me-2" :rules="[required, maxLength(255)].flat()" />
                            <v-text-field label="Telefono" v-model="peticion.telefono" type="number"
                                prepend-inner-icon="mdi-text me-2" :rules="[required].flat()" />
                            <v-text-field label="Descripcion de la peticion" v-model="peticion.descripcion_peticion"
                                prepend-inner-icon="mdi-text me-2" :rules="[required, maxLength(255)].flat()" />
                            <v-text-field label="Fecha en que se pidio de la peticion" v-model="peticion.fecha_peticion" type="date"
                                prepend-inner-icon="mdi-text me-2" :rules="[required].flat()" />

                            <!-- Campo de fecha de inicio con validaciones -->
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-center align-center mt-n6 mb-4">
                        <v-btn class="bg-GYF2" size="large" @click="postOrPutPeticion()" :loading="loadingDialog"
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
import PeticionService from "@/services/PeticionService";
import { showConfirmDialog, showDialog } from '@/Utils/Dialogs';

const search = ref('');
const dialog = ref(false);
const isEdit = ref(false);
const peticiones = ref([]);
const loading = ref(false);
const loadingDialog = ref(false);
const peticion = ref({});
const tab = ref(null);
const form = ref(null);

const headers = [
    { title: 'Nombre', key: 'nombre_completo', align: 'center' },
    { title: 'Telefono', key: 'telefono', align: 'center' },
    { title: 'Descripcion', key: 'descripcion_peticion', align: 'center' },
    { title: 'Fecha en que se pidio', key: 'fecha_peticion', align: 'center' },
    { title: 'Acciones', key: 'acciones', align: 'center' }
];

onMounted(() => {
    loadPeticiones();
});

const loadPeticiones = async () => {
    try {
        loading.value = true;
        const response = await PeticionService.get();
        peticiones.value = await response.data.dataset;
    } catch (e) {
        const message = e.response?.data?.message || 'Error cargando las peticiones';
        showDialog('error', message);
    } finally {
        loading.value = false;
    }
};

const openDialog = (item) => {
    if (item) {
        peticion.value = { ...item };
        isEdit.value = true;
    } else {
        peticion.value = {};
        isEdit.value = false;
    }
    dialog.value = true;
};

const postOrPutPeticion = async () => {
    const { valid } = await form.value.validate();
    if (!valid) return;

    try {
        loadingDialog.value = true;
        if (peticion.value.id_peticion_oracion) {
            await PeticionService.put(peticion.value, peticion.value.id_peticion_oracion);
            showDialog('success', 'Peticion actualizado correctamente');
        } else {
            await PeticionService.post(peticion.value);
            showDialog('success', 'Peticion creada correctamente');
        }
        dialog.value = false;
        loadPeticiones();
    } catch (e) {
        const message = e.response?.data?.message || 'Error al guardar la peticion';
        showDialog('error', message);
    } finally {
        loadingDialog.value = false;
    }
};

const marcarListo = async (item) => {
    try {
        const confirm = await showConfirmDialog('Terminar','Estas seguro de marcarlo como listo?','question')
        if(!confirm)return
        await PeticionService.delete(item.id_peticion_oracion);
        loadPeticiones();
        showDialog('success', 'Peticion terminada correctamente');
    } catch (e) {
        const message = e.response?.data?.message || 'Error al marcar la peticion como lista';
        showDialog('error', message);
    }
};
</script>