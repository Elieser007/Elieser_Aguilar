<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroupGeneric from '@/Components/InputGroupGeneric.vue';
import SelectInputGeneric from '@/Components/SelectInputGeneric.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';

const props = defineProps({
    productos: { type: Object }, categorias: { type: Object }
});
const form = useForm({ nombre_producto: '', precio: '', id_categoria: '' });
const v = ref({ id: '', nombre_producto: '', precio: '', categoria: '' });

const showModalView = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);
const title = ref('');
const operation = ref(1);
const msj = ref('');
const classMsj = ref('hidden');

const openModalView = (p) => {
    v.value.nombre_producto = p.nombre_producto;
    v.value.precio = p.precio;
    v.value.categoria = p.categorias?.nombre_categoria || '';
    showModalView.value = true;
}
const openModalForm = (op, p) => {
    showModalForm.value = true;
    operation.value = op;
    if (op === 1) {
        title.value = 'Crear producto';
        form.reset();
    } else {
        title.value = 'Editar producto';
        form.nombre_producto = p.nombre_producto;
        form.precio = p.precio;
        form.id_categoria = p.id_categoria;
        v.value.id = p.id;
    }
}
const openModalDel = (p) => {
    showModalDel.value = true;
    v.value.id = p.id;
    v.value.nombre_producto = p.nombre_producto;
}
const closeModalView = () => {
    showModalView.value = false;
}
const closeModalForm = () => {
    showModalForm.value = false;
    form.reset();
}
const closeModalDel = () => {
    showModalDel.value = false;
}
const save = () => {
    if (operation.value === 1) {
        form.post(route('productos.store'), {
            onSuccess: () => {
                ok('Producto creado');
            }
        });
    } else {
        form.put(route('productos.update', v.value.id), {
            onSuccess: () => {
                ok('Producto actualizado');
            }
        });
    }
};
const ok = (m) => {
    if (operation.value == 2) {
        closeModalForm();
    }
    closeModalDel();
    form.reset();
    msj.value = m;
    classMsj.value = 'block';
    setTimeout(() => {
        classMsj.value = 'hidden';
    }, 8000);
}
const deleteProducto = () => {
    form.delete(route('productos.destroy', v.value.id), {
        onSuccess: () => { ok('Producto eliminado'); }
    });
}


// Opciones de filtros habilitados
const filterOptions = [
    { id: "name", country: "Nombre del Producto" },
    { id: "categories", country: "Categoria del Producto" },
    { id: "createdAt", country: "Fecha de Ingreso" }
];

// Estado para almacenar la opción de filtro seleccionada
const selectedFilter = ref('name');

// Estados para los valores de los inputs dinámicos
const nameInput = ref('');
const categoryInput = ref('');
const createdAtStart = ref('');
const createdAtEnd = ref('');

// Opcional: Para limpiar los campos cuando el filtro cambia
watch(selectedFilter, (newFilter) => {
    if (newFilter !== 'name') {
        nameInput.value = '';
    }
    if (newFilter !== 'categories') {
        categoryInput.value = '';
    }
    if (newFilter !== 'createdAt') {
        createdAtStart.value = '';
        createdAtEnd.value = '';
    }
});

// Función para aplicar el filtro
const applyFilter = () => {
    const params = {};

    if (selectedFilter.value === 'name' && nameInput.value) {
        params.name = nameInput.value;
    } else if (selectedFilter.value === 'categories' && categoryInput.value) {
        params.categories = categoryInput.value;
    } else if (selectedFilter.value === 'createdAt') {
        if (createdAtStart.value) {
            params.createdAtFrom = createdAtStart.value;
        }
        if (createdAtEnd.value) {
            params.createdAtTo = createdAtEnd.value;
        }
    }

    router.get(route('productos.index'), params, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
};
</script>
<template>

    <Head title="Productos" />
    <AuthenticatedLayout>
        <template #header>
            Productos
            <DarkButton @click="openModalForm(1)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
            </DarkButton>
            <div class="px-4 py-2 -mx-3">

                <div class="px-4 py-2 -mx-3 flex items-center">

                    <span class="font-semibold text-blue-500">Filtro de Productos:</span>

                    <div v-if="selectedFilter === 'name'" class="mx-3">
                        <TextInput v-model="nameInput" placeholder="Buscar por Nombre del Producto" />
                    </div>

                    <div v-if="selectedFilter === 'categories'" class="mx-3">
                        <SelectInputGeneric v-model="categoryInput" :text="'Categoría del Producto'"
                            :options="props.categorias" :optIdField="'id'" :optTextField="'nombre_categoria'" />
                    </div>

                    <div v-if="selectedFilter === 'createdAt'" class="mx-3 flex items-center">
                        <DateInput v-model="createdAtStart" title="Fecha Desde" />
                        <span class="mx-2 text-gray-500">-</span>
                        <DateInput v-model="createdAtEnd" title="Fecha Hasta" />
                    </div>

                    <SelectInput :options="filterOptions" v-model="selectedFilter" />

                    <div v-if="selectedFilter" class="mx-3">
                        <PrimaryButton @click="applyFilter">
                            Aplicar Filtro
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </template>
        <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
            <div class="flex justify-center items-center w-12 bg-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-green-800">Success</span>
                    <p class="text-sm text-gray-600">{{ msj }}</p>
                </div>
            </div>
        </div>
        <div class="w-full overflow-hidden rounded-lg border shadow-md">
            <div class="w-full overflow-x-auto bg-white"></div>
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-700 uppercase border-b bg-white">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Precio</th>
                        <th class="px-4 py-3">Categoría</th>
                        <th class="px-4 py-3">Detalle</th>
                        <th class="px-4 py-3">Editar</th>
                        <th class="px-4 py-3">Eliminar</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    <tr v-for="p, i in productos" :key="p.id" class="text-gray-700">
                        <td class="px-4 py-3 text-sm">{{ (i + 1) }}</td>
                        <td class="px-4 py-3 text-sm">{{ p.nombre_producto }}</td>
                        <td class="px-4 py-3 text-sm">{{ p.precio }}</td>
                        <td class="px-4 py-3 text-sm">{{ p.categorias?.nombre_categoria }}</td>
                        <td class="px-4 py-3 text-sm">
                            <SecondaryButton @click="openModalView(p)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </SecondaryButton>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <WarningButton @click="openModalForm(2, p)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </WarningButton>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <DangerButton @click="openModalDel(p)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </DangerButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Modal :show="showModalView" @close="closeModalView">
            <div class="p-6">
                <p>Producto: <span class="text-lg font-medium text-gray-900">{{ v.nombre_producto }}</span></p>
                <p>Precio: <span class="text-lg font-medium text-gray-900">{{ v.precio }}</span></p>
                <p>Categoría: <span class="text-lg font-medium text-gray-900">{{ v.categoria }}</span></p>
            </div>
            <div class="m-6 flex justify-end">
                <SecondaryButton @click="closeModalView">Cancelar</SecondaryButton>
            </div>
        </Modal>
        <Modal :show="showModalForm" @close="closeModalForm">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
                <div class="mt-6 mb-6 space-y-6 max-w-xl">
                    <label class="block text-gray-700">Nombre</label>
                    <InputGroupGeneric :text="'Nombre'" :required="'required'" v-model="form.nombre_producto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </InputGroupGeneric>
                    <InputError class="mt-1" :message="form.errors.nombre_producto"></InputError>

                    <label class="block text-gray-700">Precio</label>
                    <InputGroupGeneric :text="'Precio'" :required="'required'" v-model="form.precio" :type="'number'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3Zm0 0V4.5m0 10.5V20" />
                        </svg>
                    </InputGroupGeneric>
                    <InputError class="mt-1" :message="form.errors.precio"></InputError>

                    <label class="block text-gray-700">Categoría</label>
                    <SelectInputGeneric :text="'Categoría'" :required="'required'" v-model="form.id_categoria"
                        :options="categorias" :optIdField="'id'" :optTextField="'nombre_categoria'">
                    </SelectInputGeneric>
                    <InputError class="mt-1" :message="form.errors.id_categoria"></InputError>
                </div>
                <div class="flex justify-end space-x-4">
                    <PrimaryButton @click="save">Guardar</PrimaryButton>
                    <SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
                </div>
            </div>

        </Modal>
        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6">
                <p class="text-2xl text-gray-500">¿Seguro que deseas eliminar a
                    <span class="text-2xl font-medium text-gray-900">{{ v.nombre_producto }}</span> ?
                </p>
                <div class="m-6 flex justify-center space-x-4">
                    <PrimaryButton @click="deleteProducto">Sí, eliminar</PrimaryButton>
                    <SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
