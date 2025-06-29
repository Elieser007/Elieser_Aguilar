<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import InputError from '@/Components/InputError.vue';
import Select2 from 'vue3-select2-component';
import $ from 'jquery';
import select2 from 'select2';


const props = defineProps({
    authors:{type:Object},
    book:{type:Object},
    authorsOfBook:{type:Object},
});

const form = useForm({
    id:'',isbn:'',description:'',title:'',
    publisher:'',release_date:'',pages:'',
    image:'',authors:[]
});

const title_form = ref(
(props.book == null) ? 'Create book' : 'Edit book'
);

const req = ref('required');
const srcImg = ref('../../storage/img/example.png');
const msj = ref();
const classMsj = ref('hidden' );
const options = ref([]);


if (props.authors && Array.isArray(props.authors)) {
  props.authors.forEach((row) => {
    options.value.push({ id: row.id, text: row.last_name + ' ' + row.name });
  });
}


if(props.book != null){
    form.isbn = props.book.isbn;
    form.title = props.book.title;
    form.description = props.book.description;
    form.release_date = props.book.release_date;
    form.publisher = props.book.publisher;
    form.pages = props.book.pages;
    form.image = props.book.image;
    form.id = props.book.id;
    srcImg.value = '../../storage'+props.book.image;
    props.authorsOfBook.map ( (row) =>(
      form.authors.push(row.id)
    ))
}



const save = () =>{
    if(props.book == null){
        form.post(route('books.store'),{
            onSuccess: () =>{ ok('Book created')}
        });
    }
    else{
        form.post(route('updatebook'));
    }
}


const ok = (m) =>{

form.reset();
msj.value = m;
classMsj.value='block'
setTimeout(() => {
    classMsj.value= 'hidden';
}, 8000);
}


const showImg = (e) =>{
    form.image = e.target.files[0];
    srcImg.value = URL.createObjectURL(e.target.files[0]);
}


</script>

<template>
    <Head title="Book"/>
    <AuthenticatedLayout>
    <template #header>
      <div class="inline-flex overflow-hidden mb-4 w-full">
        {{ title_form }}
        <NavLink :href="route('books.index')">
            <DarkButton>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>

            </DarkButton>
        </NavLink>
      </div>
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



    <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
        <div class="min-w-0 p-4 rounded-lg shadow-xs">
           <form class="mt-6 mb-6 space-y-6 max-w-xl" @submit.prevent="save">
            <InputGroup :text="'ISBN'" :required="'required'" v-model="form.isbn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>

            </InputGroup>
            <InputError :message="form.errors.isbn" />



            <InputGroup :text="'Description'" :required="'required'" v-model="form.description">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                </svg>
            </InputGroup>
            <InputError :message="form.errors.description" />



            <InputGroup :text="'Title'" :required="'required'" v-model="form.title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </InputGroup>
            <InputError :message="form.errors.title" />



            <InputGroup :text="'Publisher'" :required="'required'" v-model="form.publisher">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                </svg>

            </InputGroup>
            <InputError :message="form.errors.publisher" />



            <InputGroup :text="'Release day'" :required="'required'" v-model="form.release_date" :type="'date'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                </svg>
            </InputGroup>
            <InputError :message="form.errors.release_date" />


            <InputGroup :text="'Pages'" :required="'required'" v-model="form.pages" :type="'number'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                </svg>
            </InputGroup>
            <InputError :message="form.errors.pages" />



            <template v-if="props.book == null" >
  <InputGroup
    :text="'Image'"
    :required="'required'"
    :type="'file'"
    :accept="'image/*'"
    @change="showImg($event)"
  >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
    </svg>
  </InputGroup>
</template>

<template v-else >
  <InputGroup
    :text="'Image'"
    :type="'file'"
    :accept="'image/*'"
    @change="showImg($event)"
  >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
    </svg>
  </InputGroup>
</template>

<InputError :message="form.errors.image" />
<span class="mt-2">Add Authors</span>
<Select2
  v-model="form.authors"
  :options="options"
  :settings="{ multiple: true, width: '100%' }"
/>


<InputError :message="form.errors.authors" />
        <PrimaryButton>Save</PrimaryButton>






           </form> 
        </div>
        <div class="min-w-0 p-4 rounded-lg shadow-xs">
            <img :src="srcImg" width="500"></img>
        </div>
    </div>
</AuthenticatedLayout>
</template>