<script setup>
import { ChevronRightIcon, MinusCircleIcon, PlusCircleIcon, ChevronLeftIcon } from '@heroicons/vue/20/solid'

import { ref } from 'vue'
import { Head, useForm, router, Link } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'
import SingleService from './SingleService.vue'

const check = ref(false);
const props = defineProps({
    hospital:Object,
    services:Object,
    other_departments:Object,
    department_services:Object
})

defineOptions({ layout: [Default, Account] })

const deptForm = useForm({
    name:''
})

const addDepartment = () => {
    deptForm.post(route('department.add', `${props.hospital.id}`), {
        onSuccess: () => {
            deptForm.reset()
        },
        preserveScroll:true
    })
}

const removeDepartment = (department_id) => {
    router.delete(route('department.remove', [`${props.hospital.id}`, `${department_id}`]), {
        preserveScroll:true
    })
}

</script>

<template>
    <div>
        <div class="flex justify-between">
            <div>
                <h2 class="font-bold text-gray-900 font-mono flex items-center">
                    {{hospital.name}}
                    <ChevronRightIcon class="block h-5 w-5 text-gray-500"/>
                    Department
                    <ChevronRightIcon class="block h-5 w-5 text-gray-500"/>
                    Services
                </h2>
                <span class="text-gray-500 tracking-tighter">Check services to add them to specific departments</span>
            </div>
            <div class="flex flex-col space-y-1">
                <span class="font-mono font-semibold">Add department</span>
                <form v-on:submit.prevent="addDepartment">
                    <div class="flex items-start gap-2">
                        <!-- {{deptForm}} -->
                        <div>
                            <select v-if="other_departments.length > 0" v-model="deptForm.name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md">
                                <option value="">Choose a department</option>
                                <option v-for="department in other_departments" :key="department.id" :value="department.id">{{department.name}}</option>
                            </select>
                            <div v-if="deptForm.errors.name" class="text-sm text-red-500 mt-2">
                                Choose a department to add
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-100 py-2 px-2 rounded-lg shadow">
                            <PlusCircleIcon class="block h-6 w-6"/>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <Link v-if="$page.props.auth.user.permissions.manage_hospitals" :href="route('hospital.index')" class="flex items-center text-indigo-600 text-sm font-semibold">
            <ChevronLeftIcon class="block h-6 w-6 -ml-2" />
            <span>Go back</span>
        </Link>

        <div v-if="hospital.departments.length > 0">
            <div class="flex items-start justify-between">
                <div class="w-full flex justify-start space-x-5 overflow-x-auto">
                    <div v-for="department in hospital.departments" class="department my-3 mb-20">
                        <form v-on:submit.prevent="removeDepartment(department.id)">
                            <div class="flex justify-start">
                                <span class="text-gray-600 tracking-tighter text-sm w-64">{{department.name}}</span>
                                <button type="submit">
                                    <MinusCircleIcon class="block h-6 w-6 text-rose-500" />
                                </button>
                            </div>
                        </form>
                        <hr>
                        <div class="flex items-center gap-1">
                            <div v-if="services.length > 0">
                                <div class="mt-3">
                                    <SingleService v-for="service in services" :key="service.id" :service="service" :department="department" :hospital="hospital" :department_services="department_services"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="!$page.props.auth.user.permissions.profile_hospital" class="flex items-center justify-between">
                <span></span>
                <Link :href="route('hospital.index')" class="bg-gray-900 text-white rounded-md px-4 py-2 text-sm">Finish</Link>
            </div>
        </div>
    </div>

    <Head title="Add services" />
</template>

<style scoped>
.department{
    white-space:nowrap !important;
    width:180px;
}
</style>
