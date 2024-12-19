<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    activeBorrowings: Object,
    borrowingHistory: Object,
    user: Object
});

// Status color mapping
const statusColors = {
    available: 'bg-green-100 text-green-800',
    in_use: 'bg-blue-100 text-blue-800',
    damaged: 'bg-red-100 text-red-800',
};
</script>

<template>
    <Head title="Dashboard User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard User
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Welcome Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold">Selamat Datang, {{ user.name }}!</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Kelola peminjaman perangkat Anda di sini.
                        </p>
                    </div>
                </div>

                <!-- Active Borrowings -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold">Peminjaman Aktif</h3>
                            <Link
                                :href="route('borrowings.create')"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition"
                            >
                                Pinjam Perangkat
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perangkat</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="borrowing in activeBorrowings.data" :key="borrowing.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ borrowing.device.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ new Date(borrowing.borrow_date).toLocaleDateString() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="['px-2 py-1 rounded-full text-xs', statusColors[borrowing.device.status]]">
                                                {{ borrowing.device.status }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr v-if="activeBorrowings.data.length === 0">
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada peminjaman aktif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination class="mt-6" :links="activeBorrowings.links" />
                    </div>
                </div>

                <!-- Borrowing History -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-6">Riwayat Peminjaman</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perangkat</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="borrowing in borrowingHistory.data" :key="borrowing.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ borrowing.device.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ new Date(borrowing.borrow_date).toLocaleDateString() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ borrowing.return_date ? new Date(borrowing.return_date).toLocaleDateString() : '-' }}</td>
                                    </tr>
                                    <tr v-if="borrowingHistory.data.length === 0">
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada riwayat peminjaman
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination class="mt-6" :links="borrowingHistory.links" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
