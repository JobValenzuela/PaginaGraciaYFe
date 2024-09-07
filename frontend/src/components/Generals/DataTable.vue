<script setup>
import { showConfirmDialog } from '@/Utils/Dialogs';
import Swal from 'sweetalert2'
import { computed, onBeforeMount, ref, watch } from 'vue'

const props = defineProps([
    'title',
    'headers',
    'items',
    'loading',
    'btn_text',
    'img_route',
    'use_search',
    'no_delete',
    'no_edit',
    'custom_event',
    'custom_event_icon'
])
const emit = defineEmits(['updateOrNewItem', 'deleteItem', 'refreshItems'])

const search = ref(null)
const searchField = ref(null)

watch(searchField, () => {
    search.value = null
}, {
    deep: true
})

const filteredItems = computed(() => {
    if (!searchField.value) {
        if (!search.value) return props.items

        return props.items.filter(item => {
            return Object.keys(item).some(key => {
                return String(item[key]).toLowerCase().includes(search.value.toLowerCase())
            })
        })
    }

    if (!search.value) return props.items

    return props.items.filter(item => {
        return item[searchField.value]?.toString() == search.value
    })
})

const deleteItemConfirm = async (item) => {
    const isConfirmed = await showConfirmDialog('¿Estás seguro que deseas eliminar?', 'Esta acción no puede deshacerse')
    if (isConfirmed) emit('deleteItem', item)
}

const clickOnImage = (src) => {
    window.open(src)
}

const filterItems = computed(() => {
    const items = [...new Set(props.items.map(it => it[searchField.value]?.toString()))]
        .filter(it => it !== null && it !== undefined)

    return items.map(originalValue => {
        let modifiedValue = originalValue

        if (modifiedValue === 'true') {
            modifiedValue = '✅'
        } else if (modifiedValue === 'false') {
            modifiedValue = '❌'
        } else {
            modifiedValue = modifiedValue.replace(/_/g, ' ')
                .split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                .join(' ')
        }

        return {
            title: modifiedValue,
            value: originalValue
        }
    })
})

onBeforeMount(() => emit('refreshItems'))
</script> 

<template>
    <v-card flat>
        <v-card-title v-if="title" class="pt-6 ps-5 py-4">{{ title }}</v-card-title>
        <v-data-table :items="filteredItems" :loading="loading" :headers="headers" :items-per-page="10"
            :items-per-page-options="[5, 10, 25, 50]">
            <template v-slot:top>
                <v-row class="mt-2">
                    <v-col>
                        <div>
                            <v-btn v-if="btn_text" class="bg-buttons text-none" @click="$emit('updateOrNewItem')">
                                {{ btn_text }}
                            </v-btn>
                            <v-icon class="ms-2 text-h4" @click="$emit('refreshItems')" v-ripple>
                                mdi-refresh
                            </v-icon>
                        </div>
                    </v-col>
                </v-row>

                <v-row :class="$vuetify.display.mobile ? 'd-block' : ''" v-if="use_search" justify="end">
                    <v-col :cols="$vuetify.display.mobile ? 0 : 3">
                        <v-select v-model="searchField"
                            :items="headers.filter(it => it.key !== 'acciones' && it.key !== 'imagen')"
                            prepend-inner-icon="mdi-filter" item-value="key" label="Buscar por" clearable
                            variant="outlined"></v-select>
                    </v-col>

                    <v-col :class="$vuetify.display.mobile ? 'mt-n8' : ''" :cols="$vuetify.display.mobile ? 0 : 4">
                        <v-text-field v-if="!searchField" label="Buscar" v-model="search"
                            prepend-inner-icon="bi bi-search me-2" variant="outlined" clearable></v-text-field>

                        <v-autocomplete v-else :items="filterItems" label="Buscar" v-model="search"
                            prepend-inner-icon="bi bi-search me-2" variant="outlined" clearable></v-autocomplete>
                    </v-col>
                </v-row>
            </template>

            <template v-slot:loading>
                <v-skeleton-loader type="table-row@5"></v-skeleton-loader>
            </template>

            <template v-slot:item.imagen="{ item }">
                <v-card class="my-2 cursor-pointer" elevation="2" rounded @click="clickOnImage(img_route + item.imagen)">
                    <v-img :src="img_route + item.imagen" height="82" cover></v-img>
                </v-card>
            </template>

            <template v-slot:item.check="{ item }">
                <v-chip :color="item.check ? 'success' : 'error'">
                    <p>{{ item.check ? '✅' : '❌' }}</p>
                </v-chip>
            </template>

            <template v-slot:item.acciones="{ item }">
                <v-icon v-if="!no_edit" color="primary" class="me-3" @click="$emit('updateOrNewItem', item)">
                    mdi-pencil
                </v-icon>
                <v-icon v-if="!no_delete" color="error" class="me-3" @click="deleteItemConfirm(item)">
                    mdi-delete
                </v-icon>
                <v-icon v-if="custom_event" color="info" @click="custom_event(item)">
                    {{ custom_event_icon }}
                </v-icon>
            </template>

            <template v-slot:no-data>
                <p class="mt-6 mb-4">Sin información</p>
            </template>
        </v-data-table>
    </v-card>
</template>