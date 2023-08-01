<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import moment from "moment";
import { useForm } from '@inertiajs/vue3';

import Alert from "@/Components/alert.vue";
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const expences = ref([]);
const editMode = ref(false);
const deleteMode = ref(false);
const toBeEditedExpence = ref(null);
const processing = ref(false);

const hasResponse = ref(false);
const alertMessage = ref("");
const responseType = ref("success");

const form = useForm({
    cost: '',
    description: '',
    payment_method: ''
});

const openDeleteMode = (expence) => {
    toBeEditedExpence.value = expence;
    deleteMode.value = true;
}

const closeDeleteMode = () => deleteMode.value = false;


// Edit Model Modifier
const openEditMode = (expence) => {
    toBeEditedExpence.value = expence;

    form.cost = expence.cost;
    form.description = expence.description;
    form.payment_method = expence.payment_method;

    editMode.value = true;
};
const closeEditMode = () => editMode.value = false;

const updateExpence = () => {
    processing.value = true;
    closeEditMode();

    let formData = new FormData;
        formData.append('cost', form.cost);
        formData.append('description', form.description);
        formData.append('payment_method', form.payment_method);

    axios.post(`/api/expences/${toBeEditedExpence.value.id}`, formData)
        .then((response) => {
            hasResponse.value = true;
            alertMessage.value = response.data.message;
            responseType.value = "success";
            processing.value = false;
            closeEditMode();
            getExpences();
        }).catch((error) => {
            hasResponse.value = true;
            alertMessage.value = error.response.data.message;
            responseType.value = "error";
            processing.value = false;
            openEditMode();
        });
};

const deleteExpence = () => {
    axios.delete(`/api/expences/${toBeEditedExpence.value.id}`)
        .then((res) => {
            hasResponse.value = true;
            alertMessage.value = res.data.message;
            responseType.value = "success";
            processing.value = false;
            closeDeleteMode();
            getExpences();
        }).catch((error) => {
            hasResponse.value = true;
            alertMessage.value = error.response.data.message;
            responseType.value = "error";
            processing.value = false;
            closeDeleteMode();
        });
}

const getExpences = async () => {
    expences.value = [];
    let response = await axios.get('/api/expences');
    expences.value = response.data;
}

const searchExpences = async (value) => {
    processing.value = true;
    let response = await axios.get(`/api/expences?query=${value}`);
    expences.value = [];
    expences.value = response.data;
    processing.value = false;
}

onMounted(async () => {
    await getExpences();
});
</script>

<template>
    <div>
        <div v-if="processing" class="absolute top-0 right-0 left-0 bottom-0 w-full h-full z-10 bg-gray-900/80 flex items-center justify-center">
            <div class="w-16 h-16 border-4 border-dashed rounded-full animate-spin dark:border-violet-400"></div>
        </div>

        <div class='my-10 mx-8'>
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
                    @keypress.enter="searchExpences($event.target.value)"
                    placeholder="Search Expences.."
                />
            </div>
        </div>

        <!-- Edit product -->
        <DialogModal :show="editMode" @close="closeEditMode">
            <template #title>
                Update This Record
            </template>

            <template #content>
                Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

                <div class="mt-4">
                    <div class="mb-4">
                        <InputLabel for="Price" value="Price" />
                        <TextInput v-model="form.cost" type="text" class="mt-1 block w-full" placeholder="Price" autocomplete="off" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="Description" value="Description" />
                        <TextareaInput v-model="form.description" class="mt-1 block w-full" placeholder="Description" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="Payment Method" value="Payment Method" />
                        <SelectInput class="mt-1 block w-full" placeholder="Payment Method" v-model="form.payment_method">
                            <option value="" disabled selected>Select Payment Method</option>
                            <option value="CASH">Cash</option>
                            <option value="MTN_MOMO">Mtn Momo</option>
                            <option value="CREDIT_CARD">Credit Card</option>
                        </SelectInput>
                    </div>
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="closeEditMode">
                    Cancel
                </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="updateExpence"
                >
                    Save Changes
                </PrimaryButton>
            </template>

        </DialogModal>

        <!-- Delete product -->
        <DialogModal :show="deleteMode" @close="closeDeleteMode">
            <template #title>
                Delete This record
            </template>

            <template #content>
                Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
            </template>

            <template #footer>
                <SecondaryButton @click="closeDeleteMode">
                    Cancel
                </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    @click="deleteExpence"
                >
                    Delete
                </DangerButton>
            </template>

        </DialogModal>

        <Alert :hasResponse="hasResponse" :response="alertMessage" :responseType="responseType" />

        <div class="p-6 lg:p-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-3 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent">
            <div v-for="expence in expences" :key="expence.id" class="px-5 py-4 bg-white dark:bg-gray-700 shadow rounded-lg max-w-lg">
                <div class="flex mb-4 relative">
                    <div class="mt-0.5">
                        <span class="block font-medium text-base leading-snug text-black dark:text-gray-100">Expence record</span>
                        <span class="block text-sm text-gray-500 dark:text-gray-400 font-light leading-snug">{{ moment(expence.created_at).format("ddd, MMM Y h:m A") }}</span>
                    </div>
                    <div class="absolute -top-2 z-10 right-0 inline-flex">
                        <div @click="openEditMode(expence)" class="rounded-lg cursor-pointer bg-indigo-500 text-sm font-medium text-white select-none mt-3 mr-2 px-2 py-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </div>

                        <div @click="openDeleteMode(expence)" class="rounded-lg cursor-pointer bg-red-500 text-sm font-medium text-white select-none mt-3 mr-2 px-2 py-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </div>
                    </div>
                </div>
                <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal">{{ expence.description }}</p>
                <div class="flex justify-between items-center mt-5">
                    <div class="flex ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 dark:text-slate-200 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                        </svg>
                        <span class="ml-1 text-gray-500 dark:text-indigo-400 font-bold">{{ expence.payment_method }}</span>
                    </div>
                    <div class="ml-1 text-gray-500 dark:text-red-400 font-bold">RWF {{ parseInt(expence.cost ? expence.cost : "0").toLocaleString() }}</div>
                </div>
            </div>
        </div>
    </div>
</template>
