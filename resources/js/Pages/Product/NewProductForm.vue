<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { ref } from 'vue';

const confirmingUserDeletion = ref(false);
const confirmUserDeletion = () => confirmingUserDeletion.value = true;
const closeModal = () => confirmingUserDeletion.value = false;
</script>

<template>
    <PrimaryButton type="button" @click="confirmUserDeletion">
        create new
    </PrimaryButton>

    <!-- Delete Account Confirmation Modal -->
    <DialogModal :show="confirmingUserDeletion" @close="closeModal">
        <template #title>
            Register New Product
        </template>

        <template #content>
            Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

            <div class="mt-4">
                <div class="mb-4">
                    <InputLabel for="Product Name" value="Product Name" />
                    <TextInput type="text" class="mt-1 block w-full" placeholder="Product Name" autocomplete="off" />
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Category" value="Product Category" />
                    <SelectInput class="mt-1 block w-full" placeholder="Product Category">
                        <option value="" disabled selected>Select Product Category</option>
                    </SelectInput>
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Color" value="Product Color" />
                    <TextInput type="text" class="mt-1 block w-full" placeholder="Product Color" autocomplete="off" />
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Type" value="Product Type" />
                    <SelectInput class="mt-1 block w-full" placeholder="Product Type">
                        <option value="" disabled selected>Select Product Type</option>
                    </SelectInput>
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Investor" value="Product Investor" />
                    <SelectInput class="mt-1 block w-full" placeholder="Product Investor">
                        <option value="" disabled selected>Select Product Investor</option>
                    </SelectInput>
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Description" value="Product Description" />
                    <TextareaInput class="mt-1 block w-full" placeholder="Product Description" />
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Section" value="Product Section" />
                    <SelectInput class="mt-1 block w-full" placeholder="Product Section">
                        <option value="" disabled selected>Select Product Section</option>
                    </SelectInput>
                </div>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <PrimaryButton class="ml-3">
                submit
            </PrimaryButton>
        </template>

    </DialogModal>
</template>
