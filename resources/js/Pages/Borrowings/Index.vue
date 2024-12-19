<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
    borrowings: Object,
    isAdmin: Boolean,
    reportUrl: String
});

const form = useForm({});
const showingRejectModal = ref(false);
const rejectionReason = ref('');
const selectedBorrowingId = ref(null);

const returnDevice = (borrowingId) => {
    if (confirm('apakah anda yakin ingin mengembalikan perangkat ini?')) {
        form.patch(route('borrowings.return', borrowingId));
    }
};

const getStatusColor = (returnDate) => {
    return returnDate ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
};

const formatDate = (date) => {
    return date ? new Date(date).toLocaleDateString() : '-';
};

const approve = (borrowingId) => {
    if (confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')) {
        form.post(route('borrowings.approve', borrowingId));
    }
};

const reject = (borrowingId) => {
    if (!rejectionReason.value) return;

    form.post(route('borrowings.reject', borrowingId), {
        rejection_reason: rejectionReason.value,
        onSuccess: () => {
            closeRejectModal();
        },
    });
};

const showRejectModal = (borrowingId) => {
    selectedBorrowingId.value = borrowingId;
    showingRejectModal.value = true;
};

const closeRejectModal = () => {
    showingRejectModal.value = false;
    selectedBorrowingId.value = null;
    rejectionReason.value = '';
};
</script>

<template>
    <Head title="Borrowings" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Peminjaman Perangkat</h2>

                <!-- hanya tunjukkan pinjam perangkat ke user -->
                <div class="flex items-center space-x-4">
                    <Link v-if="!isAdmin"
                          :href="route('borrowings.create')"
                          class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Pinjam Perangkat
                    </Link>

                    <!-- Download PDF untuk admin saja -->
                    <Link v-if="isAdmin"
                        :href="route('borrowings.report')"
                        method="get"
                        as="button"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Unduh Laporan PDF
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perangkat</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Denda Telat</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="borrowing in borrowings.data" :key="borrowing.id"
                                    class="hover:bg-gray-50 transition-colors duration-200 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ borrowing.user.name }}</div>
                                                <div class="text-sm text-gray-500">{{ borrowing.user.email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ borrowing.device.name }}</div>
                                        <div class="text-sm text-gray-500">{{ borrowing.device.type }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ formatDate(borrowing.borrow_date) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ formatDate(borrowing.return_date) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="[
                                            'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm',
                                            borrowing.actual_return_date
                                                ? 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-600/20'
                                                : borrowing.return_date < new Date().toISOString().split('T')[0]
                                                    ? 'bg-red-100 text-red-800 ring-1 ring-red-600/20'
                                                    : 'bg-amber-100 text-amber-800 ring-1 ring-amber-600/20'
                                        ]">
                                            {{ borrowing.actual_return_date
                                                ? 'Returned'
                                                : borrowing.return_date < new Date().toISOString().split('T')[0]
                                                    ? 'Overdue'
                                                    : 'Active'
                                            }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div v-if="!borrowing.actual_return_date" class="flex items-center space-x-2">
                                            <!-- hanya tampilkan tombol return untuk peminjaman yang sudah diapprove -->
                                            <button v-if="!isAdmin && borrowing.status === 'approved'"
                                                @click="returnDevice(borrowing.id)"
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M5 13l4 4L19 7" />
                                                </svg>
                                                Kembalikan
                                            </button>

                                            <!-- Status badge for pending -->
                                            <span v-if="borrowing.status === 'pending' && !isAdmin"
                                                  class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                                Menunggu Persetujuan
                                            </span>

                                            <!-- Tombol Setuju/Tolak -->
                                            <div v-if="isAdmin && borrowing.status === 'pending'" class="flex items-center space-x-2">
                                                <button
                                                    @click="approve(borrowing.id)"
                                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50"
                                                    :disabled="form.processing"
                                                >
                                                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    {{ form.processing ? 'Memproses...' : 'Setujui' }}
                                                </button>

                                                <button
                                                    @click="showRejectModal(borrowing.id)"
                                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50"
                                                    :disabled="form.processing"
                                                >
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Tolak
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ borrowing.late_fee }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-6">
                            <Pagination :links="borrowings.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <!-- Rejection Modal -->
    <Modal :show="showingRejectModal" @close="closeRejectModal">
        <div class="p-6">
            <h2 class="text-lg font-medium">Tolak Peminjaman</h2>
            <div class="mt-4">
                <textarea
                    v-model="rejectionReason"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    rows="3"
                    placeholder="Alasan penolakan..."
                ></textarea>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <SecondaryButton @click="closeRejectModal">Batal</SecondaryButton>
                <PrimaryButton
                    @click="reject(selectedBorrowingId)"
                    :disabled="!rejectionReason || form.processing"
                    class="bg-red-600 hover:bg-red-700"
                >
                    {{ form.processing ? 'Memproses...' : 'Konfirmasi Penolakan' }}
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
