<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import Alert from "@/Components/alert.vue";

const confirmingUserDeletion = ref(false);
const investors = ref([]);
const photoPreview = ref(null);
const photoInput = ref(null);
const processing = ref(false);

const hasResponse = ref(false);
const alertMessage = ref("");
const responseType = ref("success");

const openModal = () => confirmingUserDeletion.value = true;
const closeModal = () => confirmingUserDeletion.value = false;

const form = useForm({
    name: '',
    category: '',
    color: '',
    type: '',
    investor_id: '',
    description: '',
    meta_desc: '',
    quantity: '',
    price: '',
});

const submitNewProduct = () => {
    processing.value = true;
    closeModal();

    let formData = new FormData;
        formData.append('name', form.name);
        formData.append('category', form.category);
        formData.append('color', form.color);
        formData.append('type', form.type);
        formData.append('investor_id', form.investor_id);
        formData.append('description', form.description);
        formData.append('meta_desc', form.meta_desc);
        formData.append('image', photoInput.value.files[0]);
        formData.append('price', form.price);
        formData.append('quantity', form.quantity);

    axios.post(route('products.store'), formData)
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

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};

onMounted(async () => {
    let response = await axios.get('/api/investors');
    investors.value = response.data;
});

</script>

<template>
    <PrimaryButton type="button" @click="openModal">
        create new
    </PrimaryButton>

    <!-- Delete Account Confirmation Modal -->
    <DialogModal :show="confirmingUserDeletion" @close="closeModal">
        <template #title>
            Register New Product
        </template>

        <template #content>
            <div class="mt-4">
                <div class="mb-4">
                    <InputLabel for="Product Name" value="Product Name" />
                    <TextInput v-model="form.name" type="text" class="mt-1 block w-full" placeholder="Product Name" autocomplete="off" />
                </div>

                <!-- Profile Photo -->
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <!-- Profile Photo File Input -->
                    <input ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview">
                    <InputLabel for="photo" value="Product Image" />

                    <!-- New Product Photo Preview -->
                    <div v-show="photoPreview" class="mt-2">
                        <span class="block rounded w-20 h-20 bg-cover bg-no-repeat bg-center" :style="'background-image: url(\'' + photoPreview + '\');'"/>
                    </div>

                    <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                        Select A New Product Image
                    </SecondaryButton>
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Category" value="Product Category" />
                    <SelectInput v-model="form.category" class="mt-1 block w-full" placeholder="Product Category">
                        <option value="" disabled selected>Select Product Category</option>
                        <option value="Men">Men</option>
                        <option value="Women">Women</option>
                    </SelectInput>
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Color" value="Product Color" />
                    <TextInput type="text" class="mt-1 block w-full" v-model="form.color" placeholder="Product Color" autocomplete="off" />
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Type" value="Product Type" />
                    <SelectInput class="mt-1 block w-full" placeholder="Product Type" v-model="form.type">
                        <option value="" disabled selected>Select Product Type</option>
                        <option value="Shoes">Shoes</option>
                    </SelectInput>
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Investor" value="Product Investor" />
                    <SelectInput class="mt-1 block w-full" placeholder="Product Investor" v-model="form.investor_id">
                        <option value="">Select Product Investor</option>
                        <option :value="investor.id" v-for="investor in investors" :key="investor.id">{{ investor.name }}</option>
                    </SelectInput>
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Description" value="Product Description" />
                    <TextareaInput class="mt-1 block w-full" placeholder="Product Description" v-model="form.description" />
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Section" value="Product Section" />
                    <SelectInput class="mt-1 block w-full" placeholder="Product Section" v-model="form.meta_desc">
                        <option value="" disabled selected>Select Product Section</option>
                        <option value="Magazine">Magazine</option>
                        <option value="Bodaboda">Bodaboda</option>
                    </SelectInput>
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Quantity" value="Product Quantity" />
                    <TextInput type="number" class="mt-1 block w-full" placeholder="Product Quantity" v-model="form.quantity" />
                </div>

                <div class="mb-4">
                    <InputLabel for="Product Price" value="Product Price" />
                    <TextInput class="mt-1 block w-full" placeholder="200, 000" v-model="form.price" />
                </div>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <PrimaryButton class="ml-3 cursor-pointer" @click="submitNewProduct()">
                submit
            </PrimaryButton>
        </template>

    </DialogModal>

    <div v-if="processing" class="absolute top-0 right-0 left-0 bottom-0 w-full h-full z-50 bg-gray-900/80 flex items-center justify-center">
        <div class="w-16 h-16 border-4 border-dashed rounded-full animate-spin dark:border-violet-400"></div>
    </div>

    <Alert :hasResponse="hasResponse" :response="response" :responseType="responseType" />
</template>
