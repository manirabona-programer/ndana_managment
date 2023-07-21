<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { ref } from 'vue';

const confirmingUserDeletion = ref(false);
const confirmUserDeletion = () => confirmingUserDeletion.value = true;
const closeModal = () => confirmingUserDeletion.value = false;
</script>

<template>
    <PrimaryButton type="button" @click="confirmUserDeletion">
        add new
    </PrimaryButton>

    <!-- Delete Account Confirmation Modal -->
    <DialogModal :show="confirmingUserDeletion" @close="closeModal">
        <template #title>
            Register New Investor
        </template>

        <template #content>
            Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

            <div class="mt-4">
                <div class="mb-4">
                    <InputLabel for="Name" value="Name" />
                    <TextInput type="text" class="mt-1 block w-full" placeholder="Name" autocomplete="off" />
                </div>

                <div class="mb-4">
                    <InputLabel for="Email-Address" value="Email-Address" />
                    <TextInput type="email" class="mt-1 block w-full" placeholder="Email-Address" autocomplete="off" />
                </div>

                <div class="mb-4">
                    <InputLabel for="Phone Number" value="Phone Number" />
                    <TextInput type="text" class="mt-1 block w-full" placeholder="Phone Number" autocomplete="off" />
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
