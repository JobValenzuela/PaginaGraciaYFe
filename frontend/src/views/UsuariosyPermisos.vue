<template>
    <PrincipalLayout>
        <div>
            <!-- Card Principal -->
            <v-card class="bg-primary" elevation="24" rounded="xl">
                <v-card-title class="text-h4 text-center mt-3">
                    Administracion de usuarios y permisos
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                <div>Nuevo usuario</div>
                            </v-btn>
                            <v-icon class="ms-2 text-h4" @click="loadUsuarios()" v-ripple>
                                mdi-refresh
                            </v-icon>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar usuario" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table :items="usuarios" :loading="loading" :search="search" :headers="headers"
                                class="bg-primary">
                                <template v-slot:no-data>
                                    <v-alert :value="true" type="warning" text>
                                        No se encontraron usuarios
                                    </v-alert>
                                </template>
                                <template v-slot:loading>
                                    Cargando...
                                </template>
                                <template v-slot:item.acciones="{ item }">
                                    <v-icon color="secondary" class="me-3" @click="openDialog(item)">
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon color="error" class="me-3 cursor-pointer" @click="deleteUsuario(item)">
                                        mdi-delete
                                    </v-icon>
                                </template>
                            </v-data-table>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <!-- Dialogo para crear/editar usuario -->
            <v-dialog v-model="dialog" max-width="700px">
                <v-card class="bg-primary" rounded="xl">
                    <v-card-title class="text-center mt-2" :class="$vuetify.display.mobile ? 'text-h4' : 'text-h5'">
                        {{ isEdit ? 'Editar usuario' : 'Nuevo usuario' }}
                    </v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="">
                            <v-text-field label="Nombre de usuario" v-model="usuario.nombre_usuario" :rules="required"/>
                            <v-text-field label="Contraseña" v-model="usuario.password" :rules="isEdit ? '' : required" type="password"/>
                            <v-autocomplete label="Miembro" v-model="usuario.id_miembro" :items="miembros"
                                item-title="nombre" item-value="id_miembro" :rules="[required].flat()" />
                            <v-autocomplete label="Rol" v-model="usuario.id_rol" :items="roles"
                                item-title="nombre_rol" item-value="id_rol" :rules="[required].flat()" />
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-center align-center mt-n6 mb-4">
                        <v-btn class="bg-GYF2" size="large" @click="postOrPutUsuario()" :loading="loadingDialog"
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
import UsuariosService from "@/services/UsuariosService";
import MiembrosService from "@/services/MiembrosService";
import RolesService from "@/services/RolesService";
import { showDialog } from '@/Utils/Dialogs';

// Definir variables reactivas
const search = ref('');
const dialog = ref(false);
const isEdit = ref(false);
const usuarios = ref([]);
const miembros = ref([]);
const roles = ref([]);
const loading = ref(false);
const loadingDialog = ref(false);
const usuario = ref({});
const tab = ref(null);
const form = ref(null);

const headers = [
    { title: 'Usuario', key: 'nombre_usuario', align: 'center' },
    { title: 'Miembro', key: 'nombre', align: 'center' },
    { title: 'Rol', key: 'nombre_rol', align: 'center' },
    { title: 'Acciones', key: 'acciones', align: 'center' },
];

onMounted(() => {
    loadUsuarios();
    loadMiembros(); // Cargar los miembros al montar el componente
    loadRoles(); // Cargar los miembros al montar el componente
});

const loadUsuarios = async () => { // Cambiado a loadUsuarios
    try {
        loading.value = true;
        const response = await UsuariosService.get(); // Cambiado a UsuariosService
        usuarios.value = await response.data.dataset;
    } catch (e) {
        const message = e.response?.data?.message || 'Error cargando usuarios';
        showDialog('error', message);
    } finally {
        loading.value = false;
    }
};

const loadMiembros = async () => {
    try {
        const response = await MiembrosService.get();
        miembros.value = await response.data.dataset;
    } catch (e) {
        const message = e.response?.data?.message || 'Error cargando miembros';
        showDialog('error', message);
    }
};
const loadRoles = async () => {
    try {
        const response = await RolesService.get();
        roles.value = await response.data.dataset;
    } catch (e) {
        const message = e.response?.data?.message || 'Error cargando roles';
        console.log(e);
        showDialog('error', message);
    } 
};

// Abrir el diálogo para nueva o editar consejería
const openDialog = (item) => {
    if (item) {
        usuario.value = { ...item };
        isEdit.value = true;
        dialog.value = true;
    } else {
        usuario.value = {};
        isEdit.value = false;
        dialog.value = true;
    }
};

// Método para crear o editar usuario
const postOrPutUsuario = async () => { 
    const { valid } = await form.value.validate();
    if (!valid) return;

    try {
        loadingDialog.value = true;
        if (usuario.value.id_usuario) {
            await UsuariosService.put(usuario.value, usuario.value.id_usuario);
            showDialog('success', 'Usuario actualizado correctamente');
        } else {
            await UsuariosService.post(usuario.value);
            showDialog('success', 'Usuario creado correctamente');
        }
        dialog.value = false;
        loadUsuarios();
    } catch (e) {
        const message = e.response?.data?.message || 'Error al guardar usuario';
        showDialog('error', message);
    } finally {
        loadingDialog.value = false;
    }
};

const deleteUsuario = async (item) => { // Cambiado a deleteUsuario
    try {
        await UsuariosService.delete(item.id_usuario);
        loadUsuarios();
        showDialog('success', 'Usuario eliminada correctamente');
    } catch (e) {
        const message = e.response?.data?.message || 'Error al eliminar el usuario';
        showDialog('error', message);
    }
};
</script>