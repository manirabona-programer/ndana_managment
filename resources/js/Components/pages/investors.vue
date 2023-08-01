<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import moment from "moment";

const investors = ref([]);
const processing = ref(false);

const searchInvestors = async (value) => {
    processing.value = true;
    let response = await axios.get(`/api/investors?query=${value}`);
    investors.value = [];
    investors.value = response.data;
    processing.value = false;
}

onMounted(async () => {
    processing.value = true;
    investors.value = [];
    let response = await axios.get('/api/investors');
    investors.value = response.data;
    processing.value = false;
});
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent">
            <div v-if="processing" class="absolute top-0 right-0 left-0 bottom-0 w-full h-full z-10 bg-gray-900/80 flex items-center justify-center">
                <div class="w-16 h-16 border-4 border-dashed rounded-full animate-spin dark:border-violet-400"></div>
            </div>

            <div class='mb-10'>
                <div class="relative flex items-center w-full h-12 rounded-lg focus-within:shadow-lg bg-gray-100 dark:bg-gray-700 overflow-hidden">
                    <div class="grid place-items-center h-full w-12 text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <input
                        class="peer h-full w-full outline-none border-none text-sm bg-gray-100 text-gray-700 pr-2 dark:bg-gray-700 dark:text-gray-100"
                        type="text"
                        id="search"
                        @keypress.enter="searchInvestors($event.target.value)"
                        placeholder="Search Expences.."
                    />
                </div>
            </div>

            <div class="p-3">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 dark:text-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Name</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Email</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Product Value</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Phone Number</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Joined</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-500 mt-4">
                            <tr v-for="investor in investors" :key="investor.id">
                                <td class="p-2 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 flex-shrink-0 mr-2 sm:mr-3"><img class="rounded-full w-full h-full" src="/user.jpg" :alt="investor.name"></div>
                                        <div class="font-medium text-gray-800 dark:text-gray-100">{{ investor.name }}</div>
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left text-gray-800 dark:text-gray-100">{{ investor.email }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left font-medium text-green-500">RWF {{ parseInt(investor.product_value).toLocaleString() }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-md text-center text-gray-800 dark:text-gray-100">{{ investor.phone_number }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-md text-center text-gray-800 dark:text-gray-100">{{ moment(investor.created_at).fromNow() }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
