<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Exports from '@/Components/pages/exports.vue';
import ExportForm from './ExportForm.vue';
</script>

<template>
    <AppLayout title="Exports">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Exports
                </h2>

                <ExportForm />
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Exports />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
