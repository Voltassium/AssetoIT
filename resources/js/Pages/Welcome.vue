<script setup>
import { Head, Link } from '@inertiajs/vue3';
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome to AssetoIT" />

    <div class="relative min-h-screen bg-white ">
        <!-- Background Video -->
        <video
            autoplay
            loop
            muted
            playsinline
            class="absolute top-[5%] left-[25%] w-auto h-auto max-w-[75%] max-h-[75%] z-[1] object-cover mx-auto my-auto"
        >
            <source src="../../image/homeBG.mp4" type="video/mp4" />
            Your browser does not support the video tag.
        </video>

        <!-- Hero Section -->
        <div class="container relative mx-auto px-6 py-16 flex flex-col justify-center z-[10] h-[calc(100vh-72px)]">
            <div class="max-w-lg">
                <h1 class="mb-6 text-5xl font-black text-bold text-left text-black">
                    Get More Done with AssetoIT
                </h1>
                <p class="mb-8 text-lg text-left text-black ">
                    Sistem untuk mempermudah pemantauan dan peminjaman perangkat IT di D3 Teknik Informatika Universitas Sebelas Maret.
                </p>
                <a href="/login">
                <button class="bg-[#101540] text-white px-6 py-3 rounded-lg font-medium shadow-md hover:bg-gray-800">
                    Get Started ->
                </button>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-100 dark:bg-gray-900 py-8">
            <div class="container mx-auto px-6 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    © 2024 AssetoIT. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>
