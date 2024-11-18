<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    devices: Array,
    users: Array,
});

const form = useForm({
    user_id: '',
    device_id: '',
    borrow_date: new Date().toISOString().substr(0, 10),
    return_date: ''
});

const submit = () => {
    form.post(route('borrowings.store'));
};

const calculateMinReturn = () => {
    return form.borrow_date; // Minimum return date is the borrow date
};
</script>

<template>
    <Head title="Peminjaman Perangkat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Peminjaman Baru</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">User</label>
                                <select v-model="form.user_id"
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">Pilih User</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }}
                                    </option>
                                </select>
                                <div v-if="form.errors.user_id" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.user_id }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Perangkat</label>
                                <select v-model="form.device_id"
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">Pilih Perangkat</option>
                                    <option v-for="device in devices" :key="device.id" :value="device.id">
                                        {{ device.name }}
                                    </option>
                                </select>
                                <div v-if="form.errors.device_id" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.device_id }}
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                                    <input type="date"
                                           v-model="form.borrow_date"
                                           :max="form.return_date"
                                           class="mt-1 block w-full rounded-md border-gray-300">
                                    <div v-if="form.errors.borrow_date" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.borrow_date }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                                    <input type="date"
                                           v-model="form.return_date"
                                           :min="calculateMinReturn()"
                                           class="mt-1 block w-full rounded-md border-gray-300">
                                    <div v-if="form.errors.return_date" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.return_date }}
                                    </div>
                                </div>
                            </div>

                            <div>
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent
                                               rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                               hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900
                                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                               transition ease-in-out duration-150"
                                        :disabled="form.processing">
                                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ form.processing ? 'Menyimpan...' : 'Buat Peminjaman' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
