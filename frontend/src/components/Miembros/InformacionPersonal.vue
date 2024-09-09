<template>
    <v-card class="bg-primary mt-4" flat>
        <v-card-text>
            <v-row>
                <v-col>
                    <v-text-field label="Nombre completo" v-model="miembro.nombre_completo" />
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-text-field label="Número de celular" v-model="miembro.celular" type="tel" maxlength="15"
                    placeholder="Ej: 5551234567" />
                </v-col>
                <v-col>
                    <v-text-field label="Fecha de nacimiento" v-model="miembro.fecha_nacimiento" type="date"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-text-field label="Calle" v-model="miembro.calle"/>
                </v-col>
                <v-col>
                    <v-text-field label="Colonia" v-model="miembro.colonia" />
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-btn color="GYF2" size="large" block>Guardar</v-btn>
                </v-col>
            </v-row>
            <!-- <div class="text-center text-h5 my-2">
                    Datos de dirección
                </div> -->
        </v-card-text>
    </v-card>
</template>

<script setup>
import { useMiembroStore } from '@/stores/MiembroStore';
import { storeToRefs } from 'pinia'
const MiembroStore = useMiembroStore()
const { miembro } = storeToRefs(MiembroStore)
</script>
