<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import debounce from 'lodash/debounce';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    devices: Object,
    filters: Object,
    types: Array,
});

// Filter
const filters = ref({
    search: props.filters?.search || '',
    type: props.filters?.type || '',
    status: props.filters?.status || '',
    sort_field: props.filters?.sort_field || 'name',
    sort_direction: props.filters?.sort_direction || 'asc'
});


const STATUS_OPTIONS = {
    available: { label: 'Available', class: 'bg-green-100 text-green-800' },
    in_use: { label: 'In Use', class: 'bg-blue-100 text-blue-800' },
    damaged: { label: 'Damaged', class: 'bg-red-100 text-red-800' }
};

// Computed properties
const sortIndicator = computed(() => {
    return filters.value.sort_direction === 'asc' ? '↑' : '↓';
});

const statusClass = computed(() => (status) => {
    return STATUS_OPTIONS[status]?.class || '';
});

// Unified update function
const updateFilters = debounce((newFilters = {}) => {
    filters.value = { ...filters.value, ...newFilters };

    router.get(route('devices.index'), filters.value, {
        preserveState: true,
        preserveScroll: true,
    });
}, 300);

// Handlers
const handleSort = (field) => {
    const direction = field === filters.value.sort_field && filters.value.sort_direction === 'asc'
        ? 'desc'
        : 'asc';

    updateFilters({
        sort_field: field,
        sort_direction: direction
    });
};

const deleteDevice = async (id) => {
    if (confirm('Apakah anda yakin ingin menghapus perangkat ini?')) {
        await router.delete(route('devices.destroy', id));
    }
};
</script>

<template>
    <Head title="List Perangkat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">List Perangkat</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Header with Add Button -->
                        <div class="flex justify-between mb-6">
                            <h3 class="text-2xl font-semibold">Perangkat</h3>
                            <Link
                                v-if="$page.props.auth.user.role === 'admin'"
                                :href="route('devices.create')"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                            >
                                Tambah Perangkat Baru
                            </Link>
                        </div>

                        <!-- Search and Filters -->
                        <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Search Input -->
                            <TextInput
                                v-model="filters.search"
                                @input="updateFilters"
                                placeholder="Cari perangkat..."
                                class="w-full"
                            />

                            <select
                                v-model="filters.type"
                                @change="updateFilters"
                                class="rounded-md border-gray-300"
                            >
                                <option value="">Semua Tipe</option>
                                <option v-for="type in types" :key="type" :value="type">
                                    {{ type }}
                                </option>
                            </select>

                            <select
                                v-model="filters.status"
                                @change="updateFilters"
                                class="rounded-md border-gray-300"
                            >
                                <option value="">Semua Status</option>
                                <option v-for="(opt, key) in STATUS_OPTIONS" :key="key" :value="key">
                                    {{ opt.label }}
                                </option>
                            </select>
                        </div>

                        <!-- Table -->
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th v-for="field in ['name', 'type', 'manufacturer', 'status']"
                                        :key="field"
                                        @click="handleSort(field)"
                                        class="px-6 py-3 text-left cursor-pointer hover:bg-gray-100"
                                    >
                                        {{ field.charAt(0).toUpperCase() + field.slice(1) }}
                                        <span v-if="filters.sort_field === field" class="ml-1">
                                            {{ sortIndicator }}
                                        </span>
                                    </th>
                                    <th v-if="$page.props.auth.user.role === 'admin'" scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="device in devices.data" :key="device.id">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ device.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ device.type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ device.manufacturer }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="['px-2 inline-flex text-xs leading-5 font-semibold rounded-full', statusClass(device.status)]">
                                            {{ device.status }}
                                        </span>
                                    </td>
                                    <td v-if="$page.props.auth.user.role === 'admin'" class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <Link :href="route('devices.edit', device.id)" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</Link>
                                        <Link :href="route('devices.show', device.id)" class="text-green-600 hover:text-green-900 mr-2">View</Link>
                                        <button @click="deleteDevice(device.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <Pagination class="mt-6" :links="devices.links" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Add any component-specific styles here */
</style>
