<script setup>
import { ref, onMounted } from "vue";
import PrincipalLayout from '@/components/General/PrincipalLayout.vue';
import { maxLength, required } from "@/Utils/Rules";
import EventosService from "@/services/EventosService";
import MiembrosService from "@/services/MiembrosService";
import { showDialog } from '@/Utils/Dialogs';

// Definir variables reactivas
const search = ref('');
const dialog = ref(false);
const isEdit = ref(false);
const eventos = ref([]);
const miembros = ref([]);
const loading = ref(false);
const loadingDialog = ref(false);
const evento = ref({});
const tab = ref(null);
const form = ref(null);

const headers = [
    { title: 'Nombre del evento', key: 'nombre', align: 'center' },
    { title: 'Hora', key: 'hora', align: 'center' },
    { title: 'Fecha', key: 'fecha', align: 'center' },
    { title: 'Publicidad', key: 'publicidad', align: 'center' },
    { title: 'Costo', key: 'costo', align: 'center' },
    { title: 'Acciones', key: 'acciones', align: 'center' },
];

onMounted(() => {
    loadEventos();
    loadMiembros(); // Cargar los miembros al montar el componente
});

const loadEventos = async () => {
    try {
        loading.value = true;
        const response = await EventosService.get();
        eventos.value = await response.data.dataset;
    } catch (e) {
        const message = e.response?.data?.message || 'Error cargando eventos';
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

// Abrir el diálogo para nuevo o editar evento
const openDialog = (item) => {
    if (item) {
        evento.value = { ...item };
        isEdit.value = true;
        dialog.value = true;
    } else {
        evento.value = {};
        isEdit.value = false;
        dialog.value = true;
    }
};

// Método para crear o editar evento
const postOrPutEvento = async () => {
    const { valid } = await form.value.validate();
    if (!valid) return;

    try {
        loadingDialog.value = true;
        if (evento.value.id_evento) {
            await EventosService.put(evento.value, evento.value.id_evento);
            showDialog('success', 'Evento actualizado correctamente');
        } else {
            await EventosService.post(evento.value);
            showDialog('success', 'Evento creado correctamente');
        }
        dialog.value = false;
        loadEventos();
    } catch (e) {
        const message = e.response?.data?.message || 'Error al guardar evento';
        showDialog('error', message);
    } finally {
        loadingDialog.value = false;
    }
};

const deleteEvento = async (item) => {
    try {
        await EventosService.delete(item.id_evento);
        loadEventos();
        showDialog('success', 'Evento eliminado correctamente');
    } catch (e) {
        const message = e.response?.data?.message || 'Error al eliminar evento';
        showDialog('error', message);
    }
};
</script>

<template>
    <PrincipalLayout>
        <div>
            <!-- Card Principal -->
            <v-card class="bg-primary" elevation="24" rounded="xl">
                <v-card-title class="text-h4 text-center mt-3">
                    Eventos
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                <div>Nuevo evento</div>
                            </v-btn>
                            <v-icon class="ms-2 text-h4" @click="loadEventos()" v-ripple>
                                mdi-refresh
                            </v-icon>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar evento" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table :items="eventos" :loading="loading" :search="search" :headers="headers"
                                class="bg-primary">
                                <template v-slot:no-data>
                                    <v-alert :value="true" type="warning" text>
                                        No se encontraron eventos
                                    </v-alert>
                                </template>
                                <template v-slot:loading>
                                    Cargando...
                                </template>
                                <template v-slot:item.acciones="{ item }">
                                    <v-icon color="secondary" class="me-3" @click="openDialog(item)">
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon color="error" class="me-3 cursor-pointer" @click="deleteEvento(item)">
                                        mdi-delete
                                    </v-icon>
                                </template>
                            </v-data-table>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <!-- Dialogo para crear/editar eventos -->
            <v-dialog v-model="dialog" max-width="700px">
                <v-card class="bg-primary" rounded="xl">
                    <v-card-title class="text-center mt-2" :class="$vuetify.display.mobile ? 'text-h4' : 'text-h5'">
                        {{ isEdit ? 'Editar evento' : 'Nuevo evento' }}
                    </v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="">
                            <!-- Campo de nombre con validaciones -->
                            <v-text-field label="Nombre del evento" v-model="evento.nombre"
                                prepend-inner-icon="mdi-account me-2" :rules="[required, maxLength(50)].flat()"
                                class="mb-3" />

                            <!-- Campo de descripción con validaciones -->
                            <v-text-field label="Descripción" v-model="evento.descripcion"
                                prepend-inner-icon="mdi-text me-2" :rules="[maxLength(255)].flat()" />

                            <!-- Campo de fecha con validaciones -->
                            <v-text-field label="Fecha del evento" v-model="evento.fecha"
                                prepend-inner-icon="mdi-calendar" :rules="[required]" type="date" class="mb-3" />

                            <!-- Campo de hora con validaciones -->
                            <v-text-field label="Hora del evento" v-model="evento.hora" prepend-inner-icon="mdi-clock"
                                :rules="[required, { regex: /^[0-9]{1,2}:[0-9]{2}$/, message: 'Formato de hora inválido' }]"
                                type="time" class="mb-3" />

                            <!-- Campo de lugar con validaciones -->
                            <v-text-field label="Lugar del evento" v-model="evento.lugar"
                                prepend-inner-icon="mdi-map-marker" :rules="[required, maxLength(255)].flat()"
                                class="mb-3" />

                            <!-- Campo de publicidad con validaciones -->
                            <v-text-field label="Publicidad del evento" v-model="evento.publicidad"
                                prepend-inner-icon="mdi-bullhorn" :rules="[required].flat()" class="mb-3" />

                            <!-- Campo de costo con validaciones -->
                            <v-text-field label="Costo del evento (opcional)" v-model="evento.costo"
                                prepend-inner-icon="mdi-currency-usd"
                                class="mb-3" />

                            <!-- Campo de selección para el miembro encargado -->
                            <v-autocomplete label="Miembro encargado" v-model="evento.id_miembro_encargado"
                                :items="miembros" item-title="nombre" item-value="id_miembro"
                                :rules="[required].flat()" />
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-center align-center mt-n6 mb-4">
                        <v-btn class="bg-GYF2" size="large" @click="postOrPutEvento()" :loading="loadingDialog"
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
