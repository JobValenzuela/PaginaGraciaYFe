<template>
    <v-card class="bg-primary mt-4" flat>
        <v-card-text>
            <v-row>
                <v-col>

                    <v-text-field label="Fecha de primer visita" v-model="miembro.fecha_llego" />
                </v-col>
                <v-col>
                    <v-text-field label="Fecha de membresia" v-model="miembro.fecha_membresia" />

                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-text-field label="Fecha de bautismo en agua" v-model="miembro.fecha_bautismo_agua" />
                </v-col>
                <v-col>
                    <v-text-field label="Fecha de bautismo en Espiritu Santo"
                        v-model="miembro.fecha_bautismo_espiritu_santo" />
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-btn color="GYF2" size="large" block>
                        Guardar
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>
import { useMiembroStore } from '@/stores/MiembroStore';
import { storeToRefs } from 'pinia'
const MiembroStore = useMiembroStore()
const { miembro } = storeToRefs(MiembroStore)
</script>
