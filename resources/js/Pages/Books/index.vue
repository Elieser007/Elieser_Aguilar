<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
const props = defineProps({
    books:{type:Object},flash:{type:Object}
});
const form = useForm({id:'',title:''});
const showModalDel = ref(false);
const msj = ref((props.flash.success != null) ? props.flash.success: '' );
const classMsj = ref((props.flash.success != null) ? '' : 'hidden' );

const openModalDel = (b)=>{
    form.id = b.id;
    form.title = b.title;
    showModalDel.value = true;
}


const closeModalDel = ()=>{
    showModalDel.value = false;
}


const deleteBook = () =>{
   form.delete(route('books.destroy',form.id),{
    onSuccess: () => {ok('Book deleted')}
   }); 
}


const ok = (m) =>{

    closeModalDel();
    form.reset();
    msj.value = m;
    classMsj.value='block'
    setTimeout(() => {
        classMsj.value= 'hidden';
    }, 8000);
}


</script>
<template>
    <Head title="Books"/>
    <AuthenticatedLayout>
    <template #header>
      Books
    
    </template>


    <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
      <div class="flex justify-center items-center w-12 bg-green-500">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
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
  <th class="px-4 py-3">Ibsn</th>
  <th class="px-4 py-3">Title</th>
  <th class="px-4 py-3">Image</th>
  <th class="px-4 py-3">Detail</th>
  <th class="px-4 py-3">Edit</th>
  <th class="px-4 py-3">Delete</th>
</tr>

            </thead>
            <tbody class="bg-white divide-y">
                <tr v-for="b,i in books.data" :key="b.id" class="text-gray-700">
                    <td class="px-4 py-3 text-sm">
                        {{ (i+1) }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ b.isbn }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ b.title }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <img :src="'/storage/' + b.image" class="w-16 h-20 object-cover" alt="Book cover" />
                    </td>


                  
                    <td class="px-4 py-3 text-sm">
                        <NavLink :href="route('books.show',b.id)">
                        <SecondaryButton>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>

                        </SecondaryButton>
                    </NavLink>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <NavLink :href="route('books.edit',b.id)">
                        <WarningButton>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
</svg>
                        </WarningButton>
                    </NavLink>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <DangerButton @click="openModalDel(b)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>

                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
  

    <div
          class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
        <pagination :links="books.links" />
      </div>
   



    <Modal :show="showModalDel" @close="closeModalDel">
        <div class="p-6">
            <p class="text-2xl text-gray-500">Are you sure delete to
 <span class="text-2xl font-medium text-gray-900">{{ form.title }}</span> ? </p> 
                <PrimaryButton @click="deleteBook">Yes, delete</PrimaryButton>
        </div>
        <div class="m-6 flex justify-end">
            <SecondaryButton @click="closeModalDel" >Cancel</SecondaryButton>
        </div>
    </Modal>


  </AuthenticatedLayout>
</template>