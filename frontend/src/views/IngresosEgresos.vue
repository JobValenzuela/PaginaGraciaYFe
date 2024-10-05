<template>
    <PrincipalLayout>
        <div>
            <!-- Card Principal -->
            <v-card class="bg-primary" elevation="24" rounded="xl">
                <v-card-title class="text-h4 text-center mt-3">
                    Ingresos y Egresos
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="green" @click="openDialog(null, 'I')">
                                <v-icon class="me-2">mdi-cash-plus</v-icon>
                                <div v-if="!$vuetify.display.mobile">Nuevo ingreso</div>
                            </v-btn>
                            <v-btn color="red" @click="openDialog(null, 'E')" class="ms-4">
                                <v-icon class="me-2">mdi-cash-minus</v-icon>
                                <div v-if="!$vuetify.display.mobile">Nuevo egreso</div>
                            </v-btn>
                            <v-icon class="ms-2 text-h4" @click="loadIngresosEgresos()" v-ripple>
                                mdi-refresh
                            </v-icon>
                        </v-col>

                        <v-col>
                            <v-text-field label="Buscar ingreso o egreso" v-model="search"
                                prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table :items="IngresosEgresos" :loading="loading" :search="search"
                                :headers="headers" class="bg-primary">
                                <template v-slot:no-data>
                                    <v-alert :value="true" type="warning" text>
                                        No se encontraron ingresos o egresos
                                    </v-alert>
                                </template>
                                <template v-slot:loading>
                                    Cargando...
                                </template>
                                <template v-slot:item.tipo="{ item }">
                                    {{  item.tipo == 'I' ? 'Ingreso' : 'Egreso'}}
                                </template>
                                <template v-slot:item.acciones="{ item }">
                                    <v-icon color="secondary" class="me-3" @click="openDialog(item)">
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon color="error" class="me-3 cursor-pointer" @click="deleteIngresoEgreso(item)">
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
                        {{ isEdit ? ingresoegreso.tipo == 'I' ? 'Editar ingreso' : 'Editar Egreso' : ingresoegreso.tipo
                            == 'I' ?
                        'Nuevo ingreso' : 'Nuevo Egreso' }}
                    </v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="">
                            <v-text-field label="Concepto" v-model="ingresoegreso.concepto"
                                prepend-inner-icon="mdi-text me-2" :rules="[required, maxLength(100)].flat()" class="mb-2"/>
                            <v-text-field label="Descripcion" v-model="ingresoegreso.descripcion"
                                prepend-inner-icon="mdi-text me-2" :rules="[required, maxLength(255)].flat()" class="mb-2"/>
                            <v-text-field label="Cantidad" v-model="ingresoegreso.cantidad"
                                prepend-inner-icon="mdi-text me-2"  type="number" :rules="[required].flat()" class="mb-2"/>
                            <v-text-field label="Fecha" v-model="ingresoegreso.fecha"
                                prepend-inner-icon="mdi-text me-2" type="date" :rules="[required].flat()" />
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-center align-center mt-n6 mb-4">
                        <v-btn class="bg-GYF2" size="large" @click="postOrPutIngresoEgreso()" :loading="loadingDialog"
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
import IngresoEgresoService from "@/services/IngresoEgresoService";
import { showConfirmDialog, showDialog } from '@/Utils/Dialogs';

// Definir variables reactivas
const search = ref('');
const dialog = ref(false);
const isEdit = ref(false);
const IngresosEgresos = ref([]);
const loading = ref(false);
const loadingDialog = ref(false);
const ingresoegreso = ref({});
const tab = ref(null);
const form = ref(null);

const headers = [
    { title: 'Tipo', key: 'tipo', align: 'center' },
    { title: 'Concepto', key: 'concepto', align: 'center' },
    { title: 'Cantidad', key: 'cantidad', align: 'center' },
    { title: 'Fecha', key: 'fecha', align: 'center' },
    { title: 'Acciones', key: 'acciones', align: 'center' }
];

onMounted(() => {
    loadIngresosEgresos();
});

const loadIngresosEgresos = async () => {
    try {
        loading.value = true;
        const response = await IngresoEgresoService.get();
        IngresosEgresos.value = await response.data.dataset;
    } catch (e) {
        const message = e.response?.data?.message || 'Error cargando ingresos y egresos';
        showDialog('error', message);
    } finally {
        loading.value = false;
    }
};

const openDialog = (item, tipo) => {
    if (item) {
        ingresoegreso.value = { ...item };
        isEdit.value = true;
    } else {
        ingresoegreso.value = {};
        ingresoegreso.value.tipo = tipo;
        isEdit.value = false;
    }
    dialog.value = true;
};

const postOrPutIngresoEgreso = async () => {
    const { valid } = await form.value.validate();
    if (!valid) return;

    try {
        loadingDialog.value = true;
        if (ingresoegreso.value.id_ingreso_egreso) {
            await IngresoEgresoService.put(ingresoegreso.value, ingresoegreso.value.id_ingreso_egreso);
            showDialog('success', 'Actualizado correctamente');
        } else {
            await IngresoEgresoService.post(ingresoegreso.value);
            showDialog('success', 'Creado correctamente');
        }
        dialog.value = false;
        loadIngresosEgresos();
    } catch (e) {
        const message = e.response?.data?.message || 'Error al guardar';
        showDialog('error', message);
    } finally {
        loadingDialog.value = false;
    }
};

const deleteIngresoEgreso = async (item) => { 
    try {
        const confirm = await showConfirmDialog(
            'Eliminar',
            'Estas seguro de eliminar el ' + (item.tipo=='I' ? 'ingreso' : 'egreso') + ' ?',
            'warning')
        if(!confirm)return
        await IngresoEgresoService.delete(item.id_ingreso_egreso);
        loadIngresosEgresos();
        showDialog('success', 'Consejería eliminada correctamente');
    } catch (e) {
        const message = e.response?.data?.message || 'Error al eliminar';
        showDialog('error', message);
    }
};
</script>
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