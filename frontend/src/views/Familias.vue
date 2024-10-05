<template>
    <PrincipalLayout>
        <div>
            <!-- Card Principal -->
            <v-card class="bg-primary" elevation="24" rounded="xl">
                <v-card-title class="text-h4 text-center mt-3">
                    Familias
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                <div>Nuevo familia</div>
                            </v-btn>
                            <v-icon class="ms-2 text-h4" @click="loadFamilias()" v-ripple>
                                mdi-refresh
                            </v-icon>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar familia" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table :items="familias" :loading="loading" :search="search" :headers="headers"
                                class="bg-primary">
                                <template v-slot:no-data>
                                    <v-alert :value="true" type="warning" text>
                                        No se encontraron familias
                                    </v-alert>
                                </template>
                                <template v-slot:loading>
                                    Cargando...
                                </template>
                                <template v-slot:item.acciones="{ item }">
                                    <v-icon color="secondary" class="me-3" @click="openFamilia(item)">
                                        mdi-eye
                                    </v-icon>
                                    <v-icon color="secondary" class="me-3" @click="openDialog(item)">
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon color="error" class="me-3 cursor-pointer" @click="deletefamilia(item)">
                                        mdi-delete
                                    </v-icon>
                                </template>
                            </v-data-table>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <!-- Dialogo para crear/editar familias -->
            <v-dialog v-model="dialog" max-width="700px" :style="{ zIndex: 1000 }">
                <v-card class="bg-primary" rounded="xl">
                    <v-card-title class="text-center mt-2" :class="$vuetify.display.mobile ? 'text-h4' : 'text-h5'">
                        {{ isEdit ? 'Editar familia' : 'Nueva familia' }}
                    </v-card-title>
                    <v-card-text>

                        <v-form ref="form" @submit.prevent="">
                            <!-- Campo de nombre con validaciones -->
                            <v-text-field label="Nombre de la familia" v-model="familia.nombre_familia"
                                prepend-inner-icon="mdi-account me-2" :rules="[required, maxLength(30)].flat()"
                                class="mb-3" />
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-center align-center mt-n6 mb-4">
                        <v-btn class="bg-GYF2" size="large" @click="postOrPutFamilia()" :loading="loadingDialog"
                            :disabled="loadingDialog">
                            {{ isEdit ? 'Guardar' : 'Crear' }}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="dialogFamilia" max-width="900" :style="{ zIndex: 1000 }">
                <v-card class="bg-primary" rounded="xl">
                    <v-card-title class="text-center mt-4 text-capitalize"
                        :class="$vuetify.display.mobile ? 'text-h4' : 'text-h5'">
                        Familia: {{ familia.nombre_familia }}
                    </v-card-title>
                    <v-card-text>
                        <v-row align="center" class="mt-2">
                            <v-col>
                                <v-btn color="GYF2" @click="dialogMiembro = true">
                                    <div>Añadir miembro a la familia</div>
                                </v-btn>
                                <v-icon class="ms-2 text-h4" @click="loadFamilias()" v-ripple>
                                    mdi-refresh
                                </v-icon>
                            </v-col>
                            <v-col>
                                <v-text-field label="Buscar miembro" v-model="searchMiembro"
                                    prepend-inner-icon="mdi-magnify" />
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-data-table :items="miembrosFamilia" :loading="loading" :search="searchMiembro"
                                    :headers="headersFamilia" class="bg-primary">
                                    <template v-slot:no-data>
                                        <v-alert :value="true" type="warning" text>
                                            No se encontraron familias
                                        </v-alert>
                                    </template>
                                    <template v-slot:loading>
                                        Cargando...
                                    </template>
                                    <template v-slot:item.acciones="{ item }">
                                        <v-icon color="error" class="me-3 cursor-pointer"
                                            @click="deleteMiembrofamilia(item)">
                                            mdi-delete
                                        </v-icon>
                                    </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <v-dialog v-model="dialogMiembro" max-width="900" :style="{ zIndex: 1000 }">
                <v-card rounded="xl" class="bg-primary">
                    <v-card-title class="text-center mt-4 text-capitalize"
                        :class="$vuetify.display.mobile ? 'text-h4' : 'text-h5'">
                        Añadir miembro a la familia {{ familia.nombre_familia }}
                    </v-card-title>
                    <v-card-text>
                        <v-autocomplete :items="miembros" label="Miembro" item-title="nombre" item-value="id_miembro" v-model="miembro.id_miembro"/>
                        <v-text-field v-model="miembro.rol_en_familia" label="Rol en la familia"/>
                        <v-btn class="bg-GYF2" size="large" @click="addMiembro()">
                            Añadir miembro
                        </v-btn>
                    </v-card-text>
                </v-card>
            </v-dialog>

        </div>
    </PrincipalLayout>
</template>
<script setup>
import { ref, onMounted } from "vue";
import PrincipalLayout from '@/components/General/PrincipalLayout.vue';
import { maxLength, required } from "@/Utils/Rules";
import FamiliaService from "@/services/FamiliaService";
import MiembrosService from "@/services/MiembrosService";
import { showConfirmDialog, showDialog } from '@/Utils/Dialogs';

// Definir variables reactivas
const search = ref('');
const dialog = ref(false);
const isEdit = ref(false);
const familias = ref([]);
const miembros = ref([]);
const loading = ref(false);
const loadingDialog = ref(false);
const familia = ref({});
const tab = ref(null);
const form = ref(null);
const dialogFamilia = ref(false)
const miembrosFamilia = ref([])
const searchMiembro = ref('')
const dialogMiembro = ref(false)
const miembro = ref({})

const headers = [
    { title: 'Nombre de la familia', key: 'nombre_familia', align: 'center' },
    { title: 'Acciones', key: 'acciones', align: 'center' },
];
const headersFamilia = [
    { title: 'Miembro', key: 'nombre', align: 'center' },
    { title: 'Rol en la familia', key: 'rol_en_familia', align: 'center' },
    { title: 'Acciones', key: 'acciones', align: 'center' },
];

onMounted(() => {
    loadFamilias();
    loadMiembros(); // Cargar los miembros al montar el componente
});

const loadFamilias = async () => {
    try {
        loading.value = true;
        const response = await FamiliaService.get();
        familias.value = await response.data.dataset;
    } catch (e) {
        const message = e.response?.data?.message || 'Error cargando familias';
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

// Abrir el diálogo para nuevo o editar familia
const openDialog = (item) => {
    if (item) {
        familia.value = { ...item };
        isEdit.value = true;
        dialog.value = true;
    } else {
        familia.value = {};
        isEdit.value = false;
        dialog.value = true;
    }
};
const openFamilia = async (item) => {
    try {
        const response = await FamiliaService.getMiembrosFamilia(item.id_familia)
        miembrosFamilia.value = response.data.dataset
        familia.value = { ...item }
        dialogFamilia.value = true;
    } catch (e) {
        console.error(e)
        const message = e.response?.data?.message || 'Error al guardar la familia';
        showDialog('error', message);
    }
};

// Método para crear o editar familia
const postOrPutFamilia = async () => {
    const { valid } = await form.value.validate();
    if (!valid) return;

    try {
        loadingDialog.value = true;
        if (familia.value.id_familia) {
            await FamiliaService.put(familia.value, familia.value.id_familia);
            showDialog('success', 'familia actualizado correctamente');
        } else {
            await FamiliaService.post(familia.value);
            showDialog('success', 'familia creado correctamente');
        }
        dialog.value = false;
        loadFamilias();
    } catch (e) {
        const message = e.response?.data?.message || 'Error al guardar la familia';
        showDialog('error', message);
    } finally {
        loadingDialog.value = false;
    }
};

const deletefamilia = async (item) => {
    try {
        const confirm = await showConfirmDialog('¿Estas seguro de eliminar esta familia?','','warning')
        if (!confirm) return
        await FamiliaService.delete(item.id_familia);
        loadFamilias();
        showDialog('success', 'familia eliminado correctamente');
    } catch (e) {
        const message = e.response?.data?.message || 'Error al eliminar la familia';
        showDialog('error', message);
    }
};

const deleteMiembrofamilia = async (item) => {
    try {
        const confirm = await showConfirmDialog('¿Estas seguro de quitarlo de la familia?')
        if (!confirm) return
        const response = await FamiliaService.deleteMiembroFamilia(item.id_miembro_familia)
        showDialog('success', 'Eliminado con exito')
        openFamilia(familia.value)
    } catch (e) {
        const message = e.response?.data?.message || 'Error al eliminar la familia';
        showDialog('error', message);
    }
}

const addMiembro = async() => {
    if(!miembro.value.id_miembro || !miembro.value.rol_en_familia){
        showDialog('warning','Debes de llenar toda la información')
        return
    }
    try {
        const data = {
            'id_miembro' : miembro.value.id_miembro,
            'rol_en_familia' : miembro.value.rol_en_familia,
            'id_familia' : familia.value.id_familia
        }
        const response = await FamiliaService.addMiembrosFamilia(data)
        showDialog('success','Se añadio correctamente')
        dialogMiembro.value = false
        miembro.value = {}
        openFamilia(familia.value)
    } catch (e) {
        console.log(e);
        
        const message = e.response?.data?.message || 'Error al añadir el miembro';
        showDialog('error', message);
    }
}
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
