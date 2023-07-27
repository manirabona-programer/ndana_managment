<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Investors from '@/Components/pages/investors.vue';
import NewInvestorForm from './NewInvestorForm.vue';

defineProps({
    canView: String,
});
</script>

<template>
    <AppLayout title="Investors" :canView="canView">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Investors
                </h2>

                <NewInvestorForm v-if="canView" />
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Investors />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
