<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    device: Object,
});
</script>

<template>
    <Head title="Device Details" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Device Details</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-4">
                            <strong>Name:</strong> {{ device.name }}
                        </div>
                        <div class="mb-4">
                            <strong>Type:</strong> {{ device.type }}
                        </div>
                        <div class="mb-4">
                            <strong>Manufacturer:</strong> {{ device.manufacturer }}
                        </div>
                        <div class="mb-4">
                            <strong>Status:</strong> {{ device.status }}
                        </div>
                        <Link :href="route('devices.edit', device.id)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Device
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
