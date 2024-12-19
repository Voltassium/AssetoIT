<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps({
    stats: {
        type: Object,
        required: true,
    }
});

const isLoading = ref(true);
const stats = ref({
    availableDevices: 0,
    activeLoans: 0,
    totalUsers: 0,
    damagedDevices: 0,
    totalDevices: 0,
    returnedToday: 0
});

onMounted(() => {
    if (props.stats) {
        stats.value = {
            ...stats.value,
            ...props.stats
        };
        isLoading.value = false;
    }
});
</script>

<template>
    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admin Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Available Devices -->
                    <div class="overflow-hidden p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-full">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-700">Perangkat Tersedia</h3>
                                <div class="flex items-baseline">
                                    <p class="text-3xl font-bold text-blue-600">
                                        {{ isLoading ? '...' : stats.availableDevices }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Loans -->
                    <div class="overflow-hidden p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-700">Peminjaman Aktif</h3>
                                <p class="text-3xl font-bold text-green-600">
                                    {{ isLoading ? '...' : stats.activeLoans }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Users -->
                    <div class="overflow-hidden p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-purple-100 rounded-full">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-700">Total Pengguna</h3>
                                <p class="text-3xl font-bold text-purple-600">
                                    {{ isLoading ? '...' : stats.totalUsers }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <h3 class="mb-4 text-lg font-semibold text-gray-700">Menu Cepat</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Tambah Perangkat -->
                        <Link :href="route('devices.create')"
                              class="flex items-center justify-center p-3 text-white bg-blue-600 rounded hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Perangkat
                        </Link>

                        <!-- Manajemen Peminjaman -->
                        <Link :href="route('borrowings.index')"
                              class="flex items-center justify-center p-3 text-white bg-green-600 rounded hover:bg-green-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Kelola Peminjaman
                        </Link>

                        <!-- Tambah User -->
                        <Link :href="route('users.create')"
                              class="flex items-center justify-center p-3 text-white bg-purple-600 rounded hover:bg-purple-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Tambah Pengguna
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
