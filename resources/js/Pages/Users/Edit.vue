<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    nim: props.user.nim,
    email: props.user.email,
    is_active: props.user.is_active,
    role: props.user.role, // Add role field
    password: '',
    password_confirmation: '',
});

function submit() {
    form.put(route('users.update', props.user.id));
}
</script>

<template>
    <Head title="Edit User" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2>
                <Link
                    :href="route('users.index')"
                    class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-lg"
                >
                    Back
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-8">
                            <!-- Basic Information Section -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Informasi Akun</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700" for="name">Nama</label>
                                        <input
                                            v-model="form.name"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            :class="{ 'border-red-500': form.errors.name }"
                                            id="name"
                                            type="text"
                                        >
                                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700" for="nim">NIM</label>
                                        <input
                                            v-model="form.nim"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            :class="{ 'border-red-500': form.errors.nim }"
                                            id="nim"
                                            type="text"
                                        >
                                        <p v-if="form.errors.nim" class="mt-1 text-sm text-red-600">{{ form.errors.nim }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                                        <input
                                            v-model="form.email"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            :class="{ 'border-red-500': form.errors.email }"
                                            id="email"
                                            type="email"
                                        >
                                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700" for="role">Role</label>
                                        <select
                                            v-model="form.role"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            :class="{ 'border-red-500': form.errors.role }"
                                            id="role"
                                        >
                                            <option value="user">User</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                        <p v-if="form.errors.role" class="mt-1 text-sm text-red-600">{{ form.errors.role }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center mt-4">
                                    <input
                                        type="checkbox"
                                        v-model="form.is_active"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        id="is_active"
                                    >
                                    <label class="ml-2 block text-sm text-gray-900" for="is_active">Akun Aktif</label>
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div v-if="$page.props.auth.user.role === 'admin'" class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Ganti Password</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700" for="password">Password Baru</label>
                                        <input
                                            v-model="form.password"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            :class="{ 'border-red-500': form.errors.password }"
                                            id="password"
                                            type="password"
                                        >
                                        <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700" for="password_confirmation">Konfirmasi Password</label>
                                        <input
                                            v-model="form.password_confirmation"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            id="password_confirmation"
                                            type="password"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end gap-4">
                                <Link
                                    :href="route('users.index')"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Batalkan
                                </Link>
                                <button
                                    type="submit"
                                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    :disabled="form.processing"
                                >
                                    <svg v-if="form.processing" class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
