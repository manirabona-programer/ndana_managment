<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { ref } from 'vue';
import axios from 'axios';
import { useForm } from '@inertiajs/vue3';
import Alert from "@/Components/alert.vue";

const modal = ref(false);
const openModal = () => modal.value = true;
const closeModal = () => modal.value = false;

const hasResponse = ref(false);
const alertMessage = ref("");
const responseType = ref("success");
const processing = ref(false);

const form = useForm({
    name: '',
    email: '',
    phone_number: ''
});

const registerInvestor = () => {
    processing.value = true;
    closeModal();

    let formData = new FormData;
        formData.append('name', form.name);
        formData.append('email', form.email);
        formData.append('phone_number', form.phone_number);


    axios.post(`/api/investors`, formData)
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
        add new
    </PrimaryButton>

    <!-- Delete Account Confirmation Modal -->
    <DialogModal :show="modal" @close="closeModal">
        <template #title>
            Register New Investor
        </template>

        <template #content>
            <div class="mt-4">
                <div class="mb-4">
                    <InputLabel for="Name" value="Name" />
                    <TextInput type="text" v-model="form.name" class="mt-1 block w-full" placeholder="Name" autocomplete="off" />
                </div>

                <div class="mb-4">
                    <InputLabel for="Email-Address" value="Email-Address" />
                    <TextInput type="email" v-model="form.email" class="mt-1 block w-full" placeholder="Email-Address" autocomplete="off" />
                </div>

                <div class="mb-4">
                    <InputLabel for="Phone Number" value="Phone Number" />
                    <TextInput type="text" v-model="form.phone_number" class="mt-1 block w-full" placeholder="Phone Number" autocomplete="off" />
                </div>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <PrimaryButton class="ml-3" @click="registerInvestor">
                submit
            </PrimaryButton>
        </template>

    </DialogModal>

    <Alert :hasResponse="hasResponse" :response="alertMessage" :responseType="responseType" />
</template>
