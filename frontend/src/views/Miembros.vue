<script setup>
import { ref } from "vue"
import PrincipalLayout from '@/components/General/PrincipalLayout.vue';
import InformacionPersonal from "@/components/Miembros/InformacionPersonal.vue";
import FechasImportantes from "@/components/Miembros/FechasImportantes.vue";
import DiscipuladoJuan from "@/components/Miembros/DiscipuladoJuan.vue";
import HaciaLaMeta1 from "@/components/Miembros/HaciaLaMeta1.vue";
import HaciaLaMeta2 from "@/components/Miembros/HaciaLaMeta2.vue";
const search = ref('')
const dialog = ref(false)
const isEdit = ref(false)
const miembros = ref([])
const loading = ref(false)
const miembro = ref({})
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
                    Miembros
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mt-2">
                        <v-col>
                            <v-btn color="GYF2" @click="openDialog()">
                                <div>
                                    Nuevo miembro
                                </div>
                            </v-btn>
                        </v-col>
                        <v-col>
                            <v-text-field label="Buscar Miembro" v-model="search" prepend-inner-icon="mdi-magnify" />
                        </v-col>
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
                                <InformacionPersonal/>
                            </v-tabs-window-item>
                            <v-tabs-window-item value="2">
                                <FechasImportantes/>
                            </v-tabs-window-item>
                            <v-tabs-window-item value="3">
                                <DiscipuladoJuan/>
                            </v-tabs-window-item>
                            <v-tabs-window-item value="4">
                                <HaciaLaMeta1/>
                            </v-tabs-window-item>
                            <v-tabs-window-item value="5">
                                <HaciaLaMeta2/>
                            </v-tabs-window-item>
                        </v-tabs-window>
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
