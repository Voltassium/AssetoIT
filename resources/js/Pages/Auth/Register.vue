<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    agree_terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="min-h-screen flex items-center justify-center bg-gray-50">
            <div class="w-full max-w-3xl p-10 bg-white rounded-lg shadow-md">
                <!-- Header -->
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-semibold text-center">Register</h1>
                    <p class="text-gray-500">
                        Register your account and get started with ASSETOIT!
                    </p>
                </div>

                <!-- Form -->
                <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <InputLabel for="name" value="Name*" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            v-model="form.name"
                            placeholder="Enter your name"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <!-- Email -->
                    <div>
                        <InputLabel for="email" value="Email*" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            v-model="form.email"
                            placeholder="Enter your email"
                            required
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Password -->
                    <div>
                        <InputLabel for="password" value="Password*" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            v-model="form.password"
                            placeholder="Minimum 8 characters"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <InputLabel for="password_confirmation" value="Confirm Password*" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            v-model="form.password_confirmation"
                            placeholder="Minimum 8 characters"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <!-- Terms Agreement -->
                    <div class="col-span-2 mt-4 flex items-center">
                        <Checkbox
                            name="agree_terms"
                            v-model:checked="form.agree_terms"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        />
                        <span class="ml-2 text-sm text-gray-600">
                            I agree to all terms, privacy policies, and fees
                        </span>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-span-2 text-center mt-6">
                        <PrimaryButton
                            class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Register
                        </PrimaryButton>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <Link
                            href="/login"
                            class="text-indigo-600 underline hover:text-indigo-800"
                        >
                            Log in
                        </Link>
                    </p>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
