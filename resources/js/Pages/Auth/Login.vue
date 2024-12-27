<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="min-h-screen flex items-center justify-center bg-gray-50">
            <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
                <!-- Hapus spasi di atas judul dengan margin yang disesuaikan -->
                <div class="mb-4 text-center">
                    <h1 class="text-xl font-semibold">Login</h1>
                    <p class="text-gray-500">See your growth and get support!</p>
                </div>

                <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Email" class="text-gray-700" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            v-model="form.email"
                            placeholder="Enter your email"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Password" class="text-gray-700" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            v-model="form.password"
                            placeholder="Minimum 8 characters"
                            required
                            autocomplete="current-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mt-4 flex items-center">
                        <Checkbox
                            name="remember"
                            v-model:checked="form.remember"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        />
                        <span class="ms-2 text-sm text-gray-600">ingat Saya</span>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm text-indigo-600 underline hover:text-indigo-800"
                        >
                            Lupa Password?
                        </Link>
                        <PrimaryButton
                            class="ml-4 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Login
                        </PrimaryButton>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum Daftar?
                        <Link
                            href="/register"
                            class="text-indigo-600 underline hover:text-indigo-800"
                        >
                            Buat Akun Baru
                        </Link>
                    </p>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
