<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useForm } from '@inertiajs/vue3';
import Alert from "@/Components/alert.vue";

const modal = ref(false);
const openModal = () => modal.value = true;
const closeModal = () => modal.value = false;

const products = ref([]);
const processing = ref(false);

const hasResponse = ref(false);
const alertMessage = ref("");
const responseType = ref("success");

const form = useForm({
    product_id: '',
    price: '',
    quantity: '',
    price: '',
    payment_method: ''
});

const getProducts = async () => {
    products.value = [];
    let response = await axios.get('/api/products');
    products.value = response.data;
}

const exportproduct = () => {
    processing.value = true;
    closeModal();

    let formData = new FormData;
        formData.append('product_id', form.product_id);
        formData.append('price', form.price);
        formData.append('quantity', form.quantity);
        formData.append('price', form.price);
        formData.append('payment_method', form.payment_method);


    axios.post(`/api/exports`, formData)
        .then((response) => {
            hasResponse.value = true;
            alertMessage.value = response.data.message;
            responseType.value = "success";
            processing.value = false;

            closeModal();
            getProducts();
            form.reset();
        }).catch((error) => {
            hasResponse.value = true;
            alertMessage.value = error.response.data.message;
            responseType.value = "error";
            processing.value = false;
            openEditMode();
        });
};

onMounted(async () => {
    await getProducts();
});

</script>

<template>
    <PrimaryButton type="button" @click="openModal">
        new export
    </PrimaryButton>

    <!-- Delete Account Confirmation Modal -->
    <DialogModal :show="modal" @close="closeModal">
        <template #title>
            Export Custom Product
        </template>

        <template #content>
            Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

            <div class="mt-4">
                <div class="mb-4">
                    <InputLabel for="Product Category" value="Product" />
                    <SelectInput class="mt-1 block w-full" placeholder="Product" v-model="form.product_id">
                        <option value="" disabled selected>Select Product</option>
                        <option :value="product.id" v-for="product in products">{{ product.name }}</option>
                    </SelectInput>
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Color" value="Product Quantity" />
                    <TextInput type="number" v-model="form.quantity" class="mt-1 block w-full" placeholder="Product Quantity" autocomplete="off" />
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Price" value="Product Price" />
                    <TextInput type="text" v-model="form.price" class="mt-1 block w-full" placeholder="Product Price" autocomplete="off" />
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

            <PrimaryButton class="ml-3" @click="exportproduct">
                submit
            </PrimaryButton>
        </template>

    </DialogModal>

    <Alert :hasResponse="hasResponse" :response="alertMessage" :responseType="responseType" />
</template>
