<script setup>
import DialogModal from '@/Components/DialogModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import Alert from "@/Components/alert.vue";
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    canView: String,
});

const products = ref([]);
const investors = ref([]);

const processing = ref(false);
const editMode = ref(false);
const deleteMode = ref(false);
const toBeEditedProduct = ref(null);

const photoPreview = ref(null);
const photoInput = ref(null);

const hasResponse = ref(false);
const alertMessage = ref("");
const responseType = ref("success");

const openDeleteMode = (product) => {
    toBeEditedProduct.value = product;
    deleteMode.value = true;
}

const closeDeleteMode = () => deleteMode.value = false;

const openEditMode = (product) => {
    toBeEditedProduct.value = product;

    form.name = product.name;
    form.category = product.category;
    form.color = product.color;
    form.type = product.type;
    form.investor_id = product.investor.id;
    form.description = product.description;
    form.meta_desc = product.meta_desc;
    form.quantity = product.quantity;
    form.price = product.price;
    photoPreview.value = product.image

    editMode.value = true;
};

const closeEditMode = () => editMode.value = false;

const getProducts = async () => {
    products.value = [];
    processing.value = true;
    let response = await axios.get('/api/products');
    products.value = response.data;
    processing.value = false;
}

const getInvestors = async () => {
    let response = await axios.get('/api/investors');
    investors.value = response.data;
}

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

const updateProduct = () => {
    processing.value = true;
    closeEditMode();

    let formData = new FormData;
        formData.append('name', form.name);
        formData.append('category', form.category);
        formData.append('color', form.color);
        formData.append('type', form.type);
        formData.append('investor_id', form.investor_id);
        formData.append('description', form.description);
        formData.append('meta_desc', form.meta_desc);
        formData.append('image', (photoInput.value) ? photoInput.value.files[0] : photoPreview.value);
        formData.append('price', form.price);
        formData.append('quantity', form.quantity);

    axios.post(`/api/products/${toBeEditedProduct.value.id}`, formData)
        .then((response) => {
            hasResponse.value = true;
            alertMessage.value = response.data.message;
            responseType.value = "success";
            processing.value = false;
            closeEditMode();
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

const deleteProduct = () => {
    axios.delete(`/api/products/${toBeEditedProduct.value.id}`)
        .then((res) => {
            hasResponse.value = true;
            alertMessage.value = res.data.message;
            responseType.value = "success";
            processing.value = false;
            closeDeleteMode();
            getProducts();
        }).catch((error) => {
            hasResponse.value = true;
            alertMessage.value = error.response.data.message;
            responseType.value = "error";
            processing.value = false;
            closeDeleteMode();
        });
}

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

const searchProducts = async (value) => {
    processing.value = true;
    let response = await axios.get(`/api/products?query=${value}`);
    products.value = [];
    products.value = response.data;
    processing.value = false;
}

onMounted(async () => {
    await getProducts()
    await getInvestors()
});

</script>

<template>
    <div class="relative min-h-[50vh]">
        <div v-if="processing" class="absolute top-0 right-0 left-0 bottom-0 w-full h-full z-30 bg-gray-900/80 flex items-center justify-center">
            <div class="w-16 h-16 border-4 border-dashed rounded-full animate-spin dark:border-violet-400"></div>
        </div>

        <div class='my-10 mx-8'>
            <div class="relative flex items-center w-full h-12 rounded-lg focus-within:shadow-lg bg-gray-200 dark:bg-gray-700 overflow-hidden">
                <div class="grid place-items-center h-full w-12 text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <input
                    class="peer h-full w-full outline-none border-none text-sm text-gray-700 pr-2 dark:bg-gray-700 dark:text-gray-100"
                    type="text"
                    id="search"
                    @keypress.enter="searchProducts($event.target.value)"
                    placeholder="Search something.."
                />
            </div>
        </div>

        <!-- Edit product -->
        <DialogModal :show="editMode" @close="closeEditMode">
            <template #title>
                Update {{ toBeEditedProduct.name }}
            </template>

            <template #content>
                Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

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
                <SecondaryButton @click="closeEditMode">
                    Cancel
                </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="updateProduct"
                >
                    Save Changes
                </PrimaryButton>
            </template>

        </DialogModal>

         <!-- Delete product -->
         <DialogModal :show="deleteMode" @close="closeDeleteMode">
            <template #title>
                Delete {{ toBeEditedProduct.name }}
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
                    @click="deleteProduct"
                >
                    Delete
                </DangerButton>
            </template>

        </DialogModal>

        <Alert :hasResponse="hasResponse" :response="alertMessage" :responseType="responseType" />

        <div class="p-3 lg:p-8 grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-3 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent">
            <div v-for="product in products" :key="product.id" class="relative mx-auto w-full">
                <a href="#" class="relative inline-block duration-300 ease-in-out transition-transform transform hover:-translate-y-2 w-full">
                    <div class="shadow p-1 rounded-lg bg-white dark:bg-gray-700">
                        <div class="flex justify-center relative rounded-lg overflow-hidden h-44">
                            <div class="transition-transform duration-500 transform ease-in-out hover:scale-110 w-full">
                                <div class="absolute inset-0 bg-black opacity-3">
                                    <img :src="product.image" class="w-full h-full object-cover" :alt="product.name">
                                </div>
                            </div>

                            <div class="absolute top-0 z-10 right-0 inline-flex" v-if="canView">
                                <div @click="openEditMode(product)" class="rounded-lg bg-indigo-500 text-sm font-medium text-white select-none mt-3 mr-2 px-2 py-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </div>

                                <div @click="openDeleteMode(product)" class="rounded-lg bg-red-500 text-sm font-medium text-white select-none mt-3 mr-2 px-2 py-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-2">
                            <h2 class="font-bold text-md md:text-lg text-gray-800 dark:text-gray-50 line-clamp-1" :title="product.name">
                                {{ product.name }}
                            </h2>
                            <p class="mt-2 text-sm text-gray-800 dark:text-gray-50 line-clamp-1" :title="product.description">
                                {{  product.description }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 grid-rows-2 gap-4 p-2">
                            <p class="inline-flex flex-col xl:flex-row xl:items-center text-gray-800 dark:text-gray-50">
                                <svg class="inline-block w-4 h-4 xl:w-4 xl:h-4 mr-3 fill-current text-gray-800 dark:text-gray-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M570.53,242,512,190.75V48a16,16,0,0,0-16-16H400a16,16,0,0,0-16,16V78.75L298.53,4a16,16,0,0,0-21.06,0L5.47,242a16,16,0,0,0,21.07,24.09L64,233.27V464a48.05,48.05,0,0,0,48,48H464a48.05,48.05,0,0,0,48-48V233.27l37.46,32.79A16,16,0,0,0,570.53,242ZM480,464a16,16,0,0,1-16,16H112a16,16,0,0,1-16-16V205.27l192-168,192,168Zm0-301.25-64-56V64h64ZM208,218.67V325.34A26.75,26.75,0,0,0,234.66,352H341.3A26.76,26.76,0,0,0,368,325.34V218.67A26.75,26.75,0,0,0,341.3,192H234.66A26.74,26.74,0,0,0,208,218.67ZM240,224h96v96H240Z"></path></svg>
                                <span class="xl:mt-0">{{ product.meta_desc }}</span>
                            </p>
                            <p class="inline-flex flex-col xl:flex-row xl:items-center text-gray-800 dark:text-gray-50">
                                <svg class="inline-block w-4 h-4 xl:w-4 xl:h-4 mr-3 fill-current text-gray-800 dark:text-gray-50" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.5883 7.872H16.4286L16.7097 8.99658H6.74743V10.1211H17.4309C17.5163 10.1211 17.6006 10.1017 17.6774 10.0642C17.7542 10.0267 17.8214 9.97222 17.874 9.90487C17.9266 9.83753 17.9631 9.75908 17.9808 9.6755C17.9986 9.59192 17.997 9.5054 17.9763 9.42251L17.5883 7.872ZM17.5883 4.49829H16.4286L16.7097 5.62286H6.74743V6.74743H17.4309C17.5163 6.74742 17.6006 6.72794 17.6774 6.69046C17.7542 6.65299 17.8214 6.59851 17.874 6.53116C17.9266 6.46381 17.9631 6.38537 17.9808 6.30179C17.9986 6.2182 17.997 6.13168 17.9763 6.04879L17.5883 4.49829ZM17.4309 0H0.562286C0.413158 0 0.270139 0.0592407 0.16469 0.16469C0.0592407 0.270139 0 0.413158 0 0.562286L0 2.81143C0 2.96056 0.0592407 3.10358 0.16469 3.20903C0.270139 3.31448 0.413158 3.37372 0.562286 3.37372H4.49829V5.62286H1.28271L1.56386 4.49829H0.404143L0.0175714 6.04879C-0.00313354 6.13162 -0.00470302 6.21808 0.012982 6.30161C0.0306671 6.38514 0.0671423 6.46355 0.119641 6.53088C0.172139 6.59822 0.239283 6.65271 0.315978 6.69023C0.392673 6.72775 0.476905 6.74731 0.562286 6.74743H4.49829V8.99658H1.28271L1.56386 7.872H0.404143L0.0175714 9.42251C-0.00313354 9.50534 -0.00470302 9.5918 0.012982 9.67533C0.0306671 9.75886 0.0671423 9.83727 0.119641 9.9046C0.172139 9.97193 0.239283 10.0264 0.315978 10.0639C0.392673 10.1015 0.476905 10.121 0.562286 10.1211H4.49829V14.7228C4.12312 14.8554 3.80693 15.1164 3.60559 15.4596C3.40424 15.8028 3.33072 16.2062 3.39801 16.5984C3.4653 16.9906 3.66907 17.3464 3.9733 17.6028C4.27754 17.8593 4.66265 18 5.06057 18C5.4585 18 5.84361 17.8593 6.14784 17.6028C6.45208 17.3464 6.65585 16.9906 6.72314 16.5984C6.79043 16.2062 6.7169 15.8028 6.51556 15.4596C6.31422 15.1164 5.99803 14.8554 5.62286 14.7228V3.37372H17.4309C17.58 3.37372 17.723 3.31448 17.8285 3.20903C17.9339 3.10358 17.9932 2.96056 17.9932 2.81143V0.562286C17.9932 0.413158 17.9339 0.270139 17.8285 0.16469C17.723 0.0592407 17.58 0 17.4309 0V0ZM5.06057 16.8686C4.94936 16.8686 4.84065 16.8356 4.74818 16.7738C4.65572 16.712 4.58365 16.6242 4.54109 16.5215C4.49853 16.4187 4.4874 16.3057 4.50909 16.1966C4.53079 16.0875 4.58434 15.9873 4.66298 15.9087C4.74162 15.8301 4.8418 15.7765 4.95088 15.7548C5.05995 15.7331 5.17301 15.7443 5.27575 15.7868C5.3785 15.8294 5.46631 15.9014 5.5281 15.9939C5.58988 16.0864 5.62286 16.1951 5.62286 16.3063C5.62286 16.4554 5.56362 16.5984 5.45817 16.7039C5.35272 16.8093 5.2097 16.8686 5.06057 16.8686ZM16.8686 2.24914H1.12457V1.12457H16.8686V2.24914Z"></path>
                                </svg>
                                <span class="xl:mt-0">{{ product.category }}</span>
                            </p>
                            <p class="inline-flex flex-col xl:flex-row xl:items-center text-gray-800 dark:text-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                <span class="xl:mt-0 dark:text-yellow-400">{{ product.quantity }} QS</span>
                            </p>
                            <p class="inline-flex flex-col xl:flex-row xl:items-center text-gray-800 dark:text-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                </svg>

                                <span class="xl:mt-0">{{ product.type }}</span>
                            </p>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-flow-row p-2">
                            <div class="flex items-center">
                                <div class="relative">
                                    <div class="rounded-full w-6 h-6 md:w-8 md:h-8 bg-gray-200"></div>
                                    <span class="absolute top-0 right-0 inline-block w-3 h-3 bg-primary-red rounded-full"></span>
                                </div>

                                <p class="ml-2 text-gray-800 dark:text-gray-50 line-clamp-1">{{  product.investor.name }}</p>
                            </div>

                            <div class="flex justify-end">
                                <p class="inline-block font-semibold text-primary whitespace-nowrap leading-tight rounded-xl text-green-800 dark:text-green-600">
                                    <span class="text-sm uppercase">RWF </span><span class="text-lg">{{ parseInt(product.price).toLocaleString() }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>
