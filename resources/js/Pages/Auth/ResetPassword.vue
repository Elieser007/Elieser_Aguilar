<template>
  <GuestLayout>
    <Head title="Restablecer contraseña"/>

    <div class="flex flex-col overflow-y-auto md:flex-row">
      <div class="h-32 md:h-auto md:w-1/2">
        <img aria-hidden="true" class="object-cover w-full h-full" src="/images/forgot-password-office.jpeg" alt="Office"/>
      </div>
      <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
        <div class="w-full">
          <h1 class="mb-4 text-xl font-semibold text-gray-700">
            Olvidé mi contraseña
          </h1>

          <form @submit.prevent="submit">
            <div>
              <InputLabel for="email" value="Correo"/>
              <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username"/>
              <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
              <InputLabel for="password" value="Contraseña"/>
              <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password"/>
              <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
              <InputLabel for="password_confirmation" value="Confirmar contraseña"/>
              <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password"/>
              <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
              <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Restablecer contraseña
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
