<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    device: Object,
});

// Status color mapping
const statusColors = {
    available: 'bg-green-100 text-green-800',
    in_use: 'bg-blue-100 text-blue-800',
    damaged: 'bg-red-100 text-red-800',
};
</script>

<template>
    <Head title="Detail Perangkat" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Perangkat</h2>
                <Link
                    :href="route('devices.index')"
                    class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-lg transition duration-150 ease-in-out"
                >
                    Kembali
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Device Info Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Nama Perangkat</h3>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ device.name }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Tipe</h3>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ device.type }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Manufacturer</h3>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ device.manufacturer }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Status</h3>
                                    <span
                                        :class="['mt-1 inline-flex px-3 py-1 rounded-full text-sm font-semibold',
                                                statusColors[device.status]]"
                                    >
                                        {{ device.status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Specifications Section -->
                        <div class="mt-8">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Spesifikasi</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700">{{ device.specifications || 'Tidak ada spesifikasi' }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex gap-4">
                            <Link
                                v-if="$page.props.auth.user.role === 'admin'"
                                :href="route('devices.edit', device.id)"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Perangkat
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
