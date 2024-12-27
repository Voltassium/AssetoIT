<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    statusOptions: Array,
});

const form = useForm({
    name: '',
    type: '',
    manufacturer: '',
    specifications: '',
    count: 1,
    status: '',
});

function submit() {
    form.post(route('devices.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>

<template>
    <Head title="Tambah Perangkat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Perangkat</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="name">
                                    Nama Perangkat
                                </label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.name }"
                                >
                                <div v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="type">
                                    Tipe
                                </label>
                                <input
                                    v-model="form.type"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.type }"
                                >
                                <div v-if="form.errors.type" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.type }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="manufacturer">
                                    Vendor
                                </label>
                                <input
                                    v-model="form.manufacturer"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.manufacturer }"
                                >
                                <div v-if="form.errors.manufacturer" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.manufacturer }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="specifications">
                                    Spesifikasi
                                </label>
                                <textarea
                                    v-model="form.specifications"
                                    rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.specifications }"
                                ></textarea>
                                <div v-if="form.errors.specifications" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.specifications }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="count">
                                    Jumlah
                                </label>
                                <input
                                    v-model="form.count"
                                    type="number"
                                    min="1"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.count }"
                                >
                                <div v-if="form.errors.count" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.count }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="status">
                                    Status
                                </label>
                                <select
                                    v-model="form.status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.status }"
                                >
                                    <option value="">Pilih status</option>
                                    <option v-for="status in statusOptions" :key="status" :value="status">
                                        {{ status }}
                                    </option>
                                </select>
                                <div v-if="form.errors.status" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.status }}
                                </div>
                            </div>

                            <div class="flex items-center justify-end">
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ form.processing ? 'Menyimpan...' : 'Tambah Perangkat' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
