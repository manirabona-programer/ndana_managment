<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { ref } from 'vue';

const confirmingUserDeletion = ref(false);
const confirmUserDeletion = () => confirmingUserDeletion.value = true;
const closeModal = () => confirmingUserDeletion.value = false;
</script>

<template>
    <PrimaryButton type="button" @click="confirmUserDeletion">
        new export
    </PrimaryButton>

    <!-- Delete Account Confirmation Modal -->
    <DialogModal :show="confirmingUserDeletion" @close="closeModal">
        <template #title>
            Export Custom Product
        </template>

        <template #content>
            Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

            <div class="mt-4">
                <div class="mb-4">
                    <InputLabel for="Product Category" value="Product" />
                    <SelectInput class="mt-1 block w-full" placeholder="Product">
                        <option value="" disabled selected>Select Product</option>
                    </SelectInput>
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Color" value="Product Quantity" />
                    <TextInput type="number" class="mt-1 block w-full" placeholder="Product Quantity" autocomplete="off" />
                </div>

                <div class="mb-4">
                    <InputLabel for="Payment Method" value="Payment Method" />
                    <SelectInput class="mt-1 block w-full" placeholder="Payment Method">
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

            <PrimaryButton class="ml-3">
                submit
            </PrimaryButton>
        </template>

    </DialogModal>
</template>
