<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

// You would typically fetch these values from your backend
const availableDevices = ref(150);
const damagedDevices = ref(12);
const activeLoans = ref(45);
const totalUsers = ref(200);

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
                <div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-700">Available Devices</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ availableDevices }}</p>
                    </div>
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-700">Damaged Devices</h3>
                        <p class="text-3xl font-bold text-red-600">{{ damagedDevices }}</p>
                    </div>
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-700">Active Loans</h3>
                        <p class="text-3xl font-bold text-green-600">{{ activeLoans }}</p>
                    </div>
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-700">Total Users</h3>
                        <p class="text-3xl font-bold text-purple-600">{{ totalUsers }}</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <h3 class="mb-4 text-lg font-semibold text-gray-700">Quick Actions</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <button class="p-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                            Add New Device
                        </button>
                        <button class="p-2 text-white bg-green-600 rounded hover:bg-green-700">
                            Create New Loan
                        </button>
                        <button class="p-2 text-white bg-yellow-600 rounded hover:bg-yellow-700">
                            Report Damaged Device
                        </button>
                        <button class="p-2 text-white bg-purple-600 rounded hover:bg-purple-700">
                            Add New User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Add any component-specific styles here */
</style>
