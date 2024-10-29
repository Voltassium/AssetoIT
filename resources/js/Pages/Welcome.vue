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

    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
        <!-- Navigation -->
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Logo -->
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">
                        Asseto<span class="text-blue-600">IT</span>
                    </div>
                </div>
                <!-- Navigation Links -->
                <div class="flex items-center space-x-4">
                    <template v-if="canLogin">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition">
                                Log in
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
                                Register
                            </Link>
                        </template>
                    </template>
                </div>
            </div>
        </nav>
        <!-- Hero Section -->
        <div class="container mx-auto px-6 py-16 text-center">
            <h1 class="mb-4 text-4xl font-bold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                Sistem Inventaris Asset IT D3 Teknik Informatika
            </h1>
        </div>
        <!-- Features Section -->

        <div id="features" class="bg-gray-50 dark:bg-gray-800 py-16">
            <div class="container mx-auto px-6">
                <h2 class="mb-12 text-center text-3xl font-bold text-gray-900 dark:text-white">
                    Feature
                </h2>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-2">
                    <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-700">
                        <h3 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Asset Tracking</h3>
                        <p class="text-gray-600 dark:text-gray-300">Lihat Status Perangkat dimana Saja!</p>
                    </div>
                </div>
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
