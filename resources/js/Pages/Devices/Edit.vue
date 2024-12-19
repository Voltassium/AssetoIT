<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    device: {
        type: Object,
        required: true
    },
    statusOptions: {
        type: Array,
        required: true
    }
});

const form = useForm({
    name: props.device.name,
    type: props.device.type,
    manufacturer: props.device.manufacturer,
    specifications: props.device.specifications,
    status: props.device.status,
});

function submit() {
    form.put(route('devices.update', props.device.id), {
        preserveScroll: true
    });
}
</script>

<template>
    <Head title="Edit Device" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800">Edit Device</h2>
                <Link
                    :href="route('devices.index')"
                    class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-lg"
                >
                    Back
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="max-w-xl space-y-6">
                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="form.errors.name" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="type" value="Type" />
                                <TextInput
                                    id="type"
                                    v-model="form.type"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="form.errors.type" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="manufacturer" value="Manufacturer" />
                                <TextInput
                                    id="manufacturer"
                                    v-model="form.manufacturer"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="form.errors.manufacturer" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="specifications" value="Specifications" />
                                <textarea
                                    id="specifications"
                                    v-model="form.specifications"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    rows="3"
                                ></textarea>
                                <InputError :message="form.errors.specifications" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="status" value="Status" />
                                <select
                                    id="status"
                                    v-model="form.status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                                    <option v-for="status in statusOptions" :key="status" :value="status">
                                        {{ status }}
                                    </option>
                                </select>
                                <InputError :message="form.errors.status" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">
                                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
                                </PrimaryButton>

                                <transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                                        Saved.
                                    </p>
                                </transition>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
