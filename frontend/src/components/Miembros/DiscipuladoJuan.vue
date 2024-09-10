<template>
    <v-card class="bg-primary mt-4" flat>
        <v-card-text>
            <v-row>
                <v-col>
                    <v-text-field v-model="miembro.etapa_discipulado_juan" type="number" label="Clase en la que va la persona"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-text-field v-model="miembro.fecha_inicio_discipulado_juan" type="date" label="Fecha de inicio del discipulado" max="8"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-text-field v-model="miembro.fecha_fin_discipulado_juan" type="date" label="Fecha de inicio del discipulado"/>
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
