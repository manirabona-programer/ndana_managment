<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { ref } from 'vue';
import axios from 'axios';
import { useForm } from '@inertiajs/vue3';
import Alert from "@/Components/alert.vue";

const modal = ref(false);
const openModal = () => modal.value = true;
const closeModal = () => modal.value = false;

const processing = ref(false);
const hasResponse = ref(false);
const alertMessage = ref("");
const responseType = ref("success");

const form = useForm({
    cost: '',
    description: '',
    payment_method: ''
});

const recordExpence = () => {
    processing.value = true;
    closeModal();

    let formData = new FormData;
        formData.append('cost', form.cost);
        formData.append('description', form.description);
        formData.append('payment_method', form.payment_method);


    axios.post(`/api/expences`, formData)
        .then((response) => {
            hasResponse.value = true;
            alertMessage.value = response.data.message;
            responseType.value = "success";
            processing.value = false;
            closeModal();
        }).catch((error) => {
            hasResponse.value = true;
            alertMessage.value = error.response.data.message;
            responseType.value = "error";
            processing.value = false;
            openModal();
        });
};

</script>

<template>
    <PrimaryButton type="button" @click="openModal">
        register new
    </PrimaryButton>

    <!-- Delete Account Confirmation Modal -->
    <DialogModal :show="modal" @close="closeModal">
        <template #title>
            Create new expence
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
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <PrimaryButton class="ml-3" @click="recordExpence">
                submit
            </PrimaryButton>
        </template>

    </DialogModal>

    <Alert :hasResponse="hasResponse" :response="alertMessage" :responseType="responseType" />
</template>
