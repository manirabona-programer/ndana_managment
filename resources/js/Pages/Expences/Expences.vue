<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Expences from '@/Components/pages/expences.vue';
import NewExpenceForm from './NewExpenceForm.vue';

defineProps({
    canView: String,
});
</script>

<template>
    <AppLayout title="Expences" :canView="canView">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Expences
                </h2>

                <NewExpenceForm v-if="canView" />
            </div>
        </template>

        <div class="pb-10 pt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Expences />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
