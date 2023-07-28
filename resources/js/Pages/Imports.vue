<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Imports from '@/Components/pages/imports.vue';

defineProps({
    canView: Boolean
});
</script>

<template>
    <AppLayout title="Imports" :canView="canView">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Imports
                </h2>
            </div>
        </template>

        <div class="pb-10 pt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Imports />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
