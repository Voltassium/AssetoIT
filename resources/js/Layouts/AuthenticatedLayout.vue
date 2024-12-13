<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const showingSidebar = ref(true);

const toggleSidebar = () => {
    showingSidebar.value = !showingSidebar.value;
};
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Hamburger -->
                            <button @click="toggleSidebar" class="flex items-center px-3">
                                <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <!-- Logo -->
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Sidebar and Main Content -->
            <div class="flex">
                <!-- Sidebar -->
                <aside v-show="showingSidebar" class="w-64 bg-gray-800 text-white min-h-screen">
                    <nav class="mt-5">
                        <Link
                            v-if="$page.props.auth.user.role === 'admin'"
                            :href="route('dashboard')"
                            class="flex items-center py-2 px-4 hover:bg-gray-700 hover:border-b-2 hover:border-blue-500 transition-all"
                            :class="{ 'bg-gray-700': route().current('dashboard') }">
                            <img src="../../image/dashboard.png" class="h-5 w-5 mr-3" alt="Dashboard Icon">
                            Dashboard
                        </Link>
                        <Link
                            v-if="$page.props.auth.user.role === 'user'"
                            :href="route('dashboarduser')"
                            class="flex items-center py-2 px-4 hover:bg-gray-700 hover:border-b-2 hover:border-blue-500 transition-all"
                            :class="{ 'bg-gray-700': route().current('dashboarduser') }">
                            <img src="../../image/dashboard.png" class="h-5 w-5 mr-3" alt="Dashboard Icon">
                            Dashboard
                        </Link>
                        <Link
                            :href="route('devices.index')"
                            class="flex items-center py-2 px-4 hover:bg-gray-700 hover:border-b-2 hover:border-blue-500 transition-all"
                            :class="{ 'bg-gray-700': route().current('devices.index') }">
                            <img src="../../image/device.png" class="h-5 w-5 mr-3" alt="Device Icon">
                            List Perangkat
                        </Link>

                        <template v-if="$page.props.auth.user.role === 'admin'">
                            <Link
                                :href="route('users.index')"
                                class="flex items-center py-2 px-4 hover:bg-gray-700 hover:border-b-2 hover:border-blue-500 transition-all"
                                :class="{ 'bg-gray-700': route().current('users.index') }">
                                <img src="../../image/users.png" class="h-5 w-5 mr-3" alt="Users Icon">
                                Manajemen User
                            </Link>
                        </template>
                        <Link
                            :href="route('borrowings.index')"
                            class="flex items-center py-2 px-4 hover:bg-gray-700 hover:border-b-2 hover:border-blue-500 transition-all"
                            :class="{ 'bg-gray-700': route().current('borrowings.index') }">
                            <img src="../../image/peminjaman.png" class="h-5 w-5 mr-3" alt="Borrowing Icon">
                            Peminjaman
                        </Link>
                    </nav>



                </aside>

                <!-- Main Content -->
                <main class="flex-1">
                    <!-- Page Heading -->
                    <header class="bg-white shadow" v-if="$slots.header">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <slot name="header" />
                        </div>
                    </header>

                    <!-- Page Content -->
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <slot />
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>
