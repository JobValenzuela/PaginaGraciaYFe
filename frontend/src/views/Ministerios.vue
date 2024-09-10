<script setup>
import { ref } from "vue"
import PrincipalLayout from '@/components/General/PrincipalLayout.vue';
const search = ref('')
const dialog = ref(false)
const isEdit = ref(false)
const ministerios = ref([])
const loading = ref(false)
const ministerio = ref({})
const tab = ref()
const openDialog = (item) => {
    if (item) {
        isEdit.value = true
        dialog.value = true
    } else {
        isEdit.value = false
        dialog.value = true
    }

}
</script>
<template>
    <PrincipalLayout>
        <div>
            <v-card class="bg-primary" elevation="24" rounded="xl">
                <v-card-title class="text-h4 text-center mt-3">
                    Ministerios
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                <div>
                                    Nuevo ministerio
                                </div>
                            </v-btn>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar ministerio" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table :items="ministerios" :loading="loading" :search="search" class="bg-primary">
                                <template v-slot:no-data>
                                    <v-alert :value="true" type="warning" text>
                                        No se encontraron ministerios
                                    </v-alert>
                                </template>
                                <template v-slot:loading>
                                    cargando...
                                </template>
                            </v-data-table>

                        </v-col>
                    </v-row>

                </v-card-text>
            </v-card>
            <v-dialog v-model="dialog" width="95%" persistent>
                <v-card class="bg-primary" rounded="xl">
                    <v-card-title class="text-center mt-2" :class="$vuetify.display.mobile ? 'text-h4' : 'text-h5'">
                        {{ isEdit ? 'Editar ministerio' : 'Nuevo ministerio' }}
                    </v-card-title>
                    <v-card-text>
                    </v-card-text>
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
