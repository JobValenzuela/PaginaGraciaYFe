<template>
    <v-card class="bg-primary mt-4" flat>
        <v-card-text>
            <v-row>
                <v-col>
                    <v-text-field v-model="miembro.etapa_discipulado_hacia_la_meta_2" type="number" label="Clase en la que va la persona"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-text-field v-model="miembro.fecha_inicio_dicipulado_hacia_la_meta_2" type="date" label="Fecha de inicio hacia la meta 2" max="8"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-text-field v-model="miembro.fecha_fin_dicipulado_hacia_la_meta_2" type="date" label="Fecha de fin hacia la meta 2"/>
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
