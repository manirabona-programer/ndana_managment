<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import moment from "moment";

const productExports = ref([]);
const processing = ref(false);

const getExports = async () => {
    productExports.value = [];
    processing.value = true;
    let response = await axios.get('/api/exports');
    productExports.value = response.data;
    processing.value = false;
}

const searchExports = async (value) => {
    processing.value = true;
    let response = await axios.get(`/api/exports?query=${value}`);
    productExports.value = [];
    productExports.value = response.data;
    processing.value = false;
}


onMounted(async () => await getExports());
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent">
            <div class='mb-5'>
                <div class="relative flex items-center w-full h-12 rounded-lg focus-within:shadow-lg bg-white dark:bg-gray-700 overflow-hidden">
                    <div class="grid place-items-center h-full w-12 text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <input
                        class="peer h-full w-full outline-none border-none text-sm text-gray-700 pr-2 dark:bg-gray-700 dark:text-gray-100"
                        type="text"
                        id="search"
                        @keypress.enter="searchExports($event.target.value)"
                        placeholder="Search Imports.."
                    />
                </div>
            </div>

            <div class="p-3">
                <div class="overflow-x-auto">
                    <div v-if="processing" class="absolute top-0 right-0 left-0 bottom-0 w-full h-full z-10 bg-gray-900/80 flex items-center justify-center">
                        <div class="w-16 h-16 border-4 border-dashed rounded-full animate-spin dark:border-violet-400"></div>
                    </div>

                    <table class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 dark:text-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Image</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Category</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Color</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Type</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Investor</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Description</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Metas</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Quantity</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Final Price</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Payment Method</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Imported at</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-500 mt-4">
                            <tr v-for="product in productExports" :key="product.id">
                                <td class="p-2 whitespace-nowrap">
                                    <div class="flex-col items-center justify-left">
                                        <div class="w-10 h-10 flex-shrink-0 mr-2 sm:mr-3"><img class="rounded-full w-40 h-10" :src="product.product.image" width="40" height="40" :alt="product.product.name"></div>
                                        <div class="font-bold text-gray-800 dark:text-gray-100 mt-1">{{ product.product.name }}</div>
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left text-gray-800 dark:text-gray-100">{{ product.product.category }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left text-gray-800 dark:text-gray-100">{{ product.product.color }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left text-gray-800 dark:text-gray-100">{{ product.product.type }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left text-gray-800 dark:text-gray-100">{{ product.product.investor_id }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left text-gray-800 dark:text-gray-100 line-clamp-1 w-10">{{ product.product.description }}...</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left text-gray-800 dark:text-gray-100">{{ product.product.meta_desc }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left text-gray-800 dark:text-gray-100">{{ product.quantity }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left font-bold text-red-600">RWF {{ parseInt(product.price ? product.price : "0").toLocaleString() }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left font-bold text-indigo-200">{{ product.payment_method }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left text-gray-800 dark:text-gray-100">{{ moment(product.created_at).format("ddd, MMM Y h:m A") }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
