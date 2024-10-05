<template>
    <PrincipalLayout>
        <div>
            <!-- Card Principal -->
            <v-card class="bg-primary" elevation="24" rounded="xl">
                <v-card-title class="text-h4 text-center mt-3">
                    Mobiliario
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                <div>Nuevo registro</div>
                            </v-btn>
                            <v-icon class="ms-2 text-h4" @click="loadMobiliario()" v-ripple>
                                mdi-refresh
                            </v-icon>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar registro" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table :items="mobiliario" :loading="loading" :search="search" :headers="headers"
                                class="bg-primary">
                                <template v-slot:no-data>
                                    <v-alert :value="true" type="warning" text>
                                        No se encontro mobiliario
                                    </v-alert>
                                </template>
                                <template v-slot:loading>
                                    Cargando...
                                </template>
                                <template v-slot:item.acciones="{ item }">
                                    <v-icon color="secondary" class="me-3" @click="openDialog(item)">
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon color="error" class="me-3 cursor-pointer" @click="deleteRegistro(item)">
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
                        {{ isEdit ? 'Editar registro' : 'Nuevo registro' }}
                    </v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="">
                            <!-- Campo de descripción con validaciones -->
                            <v-text-field label="Nombre" v-model="registro.nombre"
                                prepend-inner-icon="mdi-text me-2" :rules="[required, maxLength(255)].flat()" />
                            <v-text-field label="Cantidad" v-model="registro.cantidad" type="number"
                                prepend-inner-icon="mdi-text me-2" :rules="[required].flat()" />
                            <v-text-field label="descripcion" v-model="registro.descripcion"
                                prepend-inner-icon="mdi-text me-2" :rules="[required, maxLength(255)].flat()" />

                            <!-- Campo de fecha de inicio con validaciones -->
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-center align-center mt-n6 mb-4">
                        <v-btn class="bg-GYF2" size="large" @click="postOrPutRegsitro()" :loading="loadingDialog"
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
import MobiliarioService from "@/services/MobiliarioService";
import { showConfirmDialog, showDialog } from '@/Utils/Dialogs';

const search = ref('');
const dialog = ref(false);
const isEdit = ref(false);
const mobiliario = ref([]); 
const loading = ref(false);
const loadingDialog = ref(false);
const registro = ref({}); 
const tab = ref(null);
const form = ref(null);

const headers = [
    { title: 'Nombre', key: 'nombre', align: 'center' },
    { title: 'Cantidad', key: 'cantidad', align: 'center' },
    { title: 'Descripcion', key: 'descripcion', align: 'center' },
    { title: 'Acciones', key: 'acciones', align: 'center' }
];

onMounted(() => {
    loadMobiliario();
});

const loadMobiliario = async () => {
    try {
        loading.value = true;
        const response = await MobiliarioService.get();
        mobiliario.value = await response.data.dataset;
    } catch (e) {
        const message = e.response?.data?.message || 'Error cargando consejerías';
        showDialog('error', message);
    } finally {
        loading.value = false;
    }
};

const openDialog = (item) => {
    if (item) {
        registro.value = { ...item };
        isEdit.value = true;
    } else {
        registro.value = {};
        isEdit.value = false;
    }
    dialog.value = true;
};

const postOrPutRegsitro = async () => {
    const { valid } = await form.value.validate();
    if (!valid) return;

    try {
        loadingDialog.value = true;
        if (registro.value.id_mobiliario) { 
            await MobiliarioService.put(registro.value, registro.value.id_mobiliario);
            showDialog('success', 'Registro actualizado correctamente en el mobiliario');
        } else {
            await MobiliarioService.post(registro.value);
            showDialog('success', 'Registro creado correctamente en el mobiliario');
        }
        dialog.value = false;
        loadMobiliario();
    } catch (e) {
        const message = e.response?.data?.message || 'Error al registrarlo en el mobiliario';
        showDialog('error', message);
    } finally {
        loadingDialog.value = false;
    }
};

const deleteRegistro = async (item) => { 
    try {
        const confirm = await showConfirmDialog('Eliminar','Estas seguro de eliminarlo?','warning')
        if(!confirm)return
        await MobiliarioService.delete(item.id_mobiliario); 
        loadMobiliario();
        showDialog('success', 'Regsitro eliminado correctamente');
    } catch (e) {
        const message = e.response?.data?.message || 'Error al eliminar el registro del mobiliario';
        showDialog('error', message);
    }
};
</script>