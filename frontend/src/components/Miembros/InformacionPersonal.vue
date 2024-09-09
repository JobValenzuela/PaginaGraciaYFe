<template>
        <v-card class="bg-primary">
            <v-card-text>
                <v-text-field label="Nombre completo" v-model="miembro.nombre_completo" />
                <v-text-field label="Número de celular" v-model="miembro.celular" type="tel" maxlength="15"
                    placeholder="Ej: 5551234567">
                </v-text-field>
            </v-card-text>
        </v-card>
</template>

<script setup>
    
</script>

<style lang="scss" scoped></style>