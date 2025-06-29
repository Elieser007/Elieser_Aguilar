<script>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';

// Opciones de filtros habilitados
const filterOptions = [
  { id: "name", country: "Nombre del Usuario" },
  { id: "email", country: "Correo Electrónico" },
  { id: "createdAt", country: "Fecha de Ingreso" }
];

// Estado para almacenar la opción de filtro seleccionada
const selectedFilter = ref('name');

// Estados para los valores de los inputs dinámicos
const nameInput = ref('');
const emailInput = ref('');
const createdAtStart = ref('');
const createdAtEnd = ref('');

// Opcional: Para limpiar los campos cuando el filtro cambia
watch(selectedFilter, (newFilter) => {
  if (newFilter !== 'name') {
    nameInput.value = '';
  }
  if (newFilter !== 'email') {
    emailInput.value = '';
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
  } else if (selectedFilter.value === 'email' && emailInput.value) {
    params.email = emailInput.value;
  } else if (selectedFilter.value === 'createdAt') {
    if (createdAtStart.value) {
      params.createdAtFrom = createdAtStart.value;
    }
    if (createdAtEnd.value) {
      params.createdAtTo = createdAtEnd.value;
    }
  }

  router.get(route('users.index'), params, {
    preserveState: true,
    preserveScroll: true,
    replace: true
  });
};
</script>
<template>

  <Head title="Users" />

  <AuthenticatedLayout>
    <template #header>
      Usuarios
    </template>

    <div class="p-4 bg-white rounded-lg shadow-xs">
      <div class="inline-flex justify-center overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md">

        <div class="px-4 py-2 -mx-3 flex items-center">

          <span class="font-semibold text-blue-500">Filtro de Usuarios:</span>

          <div v-if="selectedFilter === 'name'" class="mx-3">
            <TextInput v-model="nameInput" placeholder="Buscar por Nombre del Usuario" />
          </div>

          <div v-if="selectedFilter === 'email'" class="mx-3">
            <TextInput v-model="emailInput" placeholder="Buscar por Correo Electrónico" />
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

      <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
        <div class="overflow-x-auto w-full">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                <th class="px-4 py-3">Nombre</th>
                <th class="px-4 py-3">Correo Electrónico</th>
                <th class="px-4 py-3">Fecha de Creación</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y">
              <tr v-for="user in users.data" :key="user.id" class="text-gray-700">
                <td class="px-4 py-3 text-sm">
                  {{ user.name }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ user.email }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ new Date(user.created_at).toLocaleDateString() }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div
          class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
          <pagination :links="users.links" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  users: Object
})
</script>
