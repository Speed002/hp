<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'
import useStep from '../../composables/useStep';

const {step, prevStep, nextStep} = useStep()
defineOptions({ layout: [Default, Account] })

defineProps({
    categories:Object,
    departments:Object
})
const form = useForm({
    hospital_name: '',
    user_name: '',
    user_email: '',
    user_contact: '',
    hospital_address:'',
    departments:[],
})
const storeHospital = () => {
    form.post(route('hospital.store'), {onSuccess: () => {form.reset()}})
}
</script>

<template>
    <div v-if="$page.props.auth.user.permissions.manage_hospitals" class="pb-10">
            <h2 class="font-bold text-gray-900 font-mono">Create new hospital</h2>
            <form v-on:submit.prevent="storeHospital">
                <!-- Step 1: Hospital and Admin Info -->
                <div v-if="step === 1" class="space-y-2">
                    <p class="text-gray-500 tracking-tighter">Enter hospital and administrator information: Step {{ step }} of 2</p>
                    <hr class="w-96" />

                    <div class="flex flex-wrap gap-2">
                    <div
                        v-for="field in [
                        { model: 'hospital_name', placeholder: 'Hospital name' },
                        { model: 'user_name', placeholder: 'Admin Username' },
                        { model: 'user_email', placeholder: 'email@example.com' },
                        { model: 'user_contact', placeholder: 'Contact' },
                        { model: 'hospital_address', placeholder: 'Address/Location of hospital' },
                        ]"
                        :key="field.model"
                        class="w-72"
                    >
                        <input
                        v-model="form[field.model]"
                        :placeholder="field.placeholder"
                        class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md"
                        />
                        <div class="text-sm text-red-500 mt-1">
                        {{ form.errors[field.model] }}
                        </div>
                    </div>
                    </div>
                </div>
                <div v-if="step === 2" class="space-y-2">
                    <p v-if="departments.length > 0" class="text-gray-500 tracking-tighter">Select/check departments: Step {{ step }} of 2</p>
                    <p v-else class="text-gray-500 tracking-tighter">There are no departments to choose from, please create departments!</p>
                    <hr class="w-96" />

                    <div v-if="form.errors.departments" class="text-sm text-red-500">
                    At least one department is required.
                    </div>
                    <div class="flex items-start justify-between">
                        <div v-if="categories.length > 0" class="w-full flex justify-start gap-5">
                            <div v-for="category in categories">
                                <span class="text-gray-600 tracking-tighter text-sm">{{category}}</span>
                                <div v-for="department in departments" :key="department.id">
                                    <div v-if="department.category == category" class="w-fit mb-2 flex items-center rounded-t-lg bg-blue-100 px-4 py-2 text-left text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring focus-visible:ring-purple-500/75">
                                        <input type="checkbox" v-model="form.departments" :value="department.id" class="h-4 w-4 text-blue-500 focus:ring-blue-500 rounded-md">
                                        <label for="remember" class="ml-2 block text-sm text-blue-900">{{department.name}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Step Navigation Buttons -->
                <div v-if="form.hospital_name && form.user_name && form.user_email && form.user_contact && form.hospital_address" class="mt-4 flex gap-2">
                    <button v-if="step > 1" type="button" @click="prevStep" class="bg-gray-900 px-3 py-2 text-sm font-semibold text-white rounded-md disabled:opacity-50">
                    Previous
                    </button>
                    <button v-if="step < 2" type="button" @click="nextStep" class="bg-gray-900 px-3 py-2 text-sm font-semibold text-white rounded-md disabled:opacity-50">
                    Next
                    </button>
                    <button v-if="step === 2 && departments.length > 0" type="submit" class="bg-gray-900 px-3 py-2 text-sm font-semibold text-white rounded-md disabled:opacity-50">
                    Save
                    </button>
                </div>
            </form>
    </div>
    <Head title="Create hospital" />
</template>
