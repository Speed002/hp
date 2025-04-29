<script setup>
import { Disclosure, DisclosurePanel, DisclosureButton } from '@headlessui/vue'
import { PlusCircleIcon, ChevronDownIcon } from '@heroicons/vue/20/solid'

import { ref, computed, watch } from 'vue'
import { Head, useForm, usePage, Link } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'
import Department from './Department.vue'

defineOptions({ layout: [Default, Account] })

defineProps({
    departments:Object
})

const form = useForm({
    name: '',
    category:''
})

const storeDepartment = () => {
    form.post(route('department.store'), {
        onSuccess: () => {
            form.reset()
        }
    })
}
</script>

<template>
        <div v-if="$page.props.auth.user.permissions.manage_departments">
            <Disclosure as="nav" v-slot="{ open }">
                <DisclosureButton class="text-left flex items-center justify-between space-x-5 w-full">
                    <div>
                    <h2 class="font-bold text-gray-900 font-mono">Create new department</h2>
                    <span class="text-gray-500 tracking-tighter">Note: something department -> something_department, clinical -> clinical</span>
                    </div>
                    <component :is="open ? ChevronDownIcon : PlusCircleIcon" class="h-6 w-6" />
                </DisclosureButton>
                <DisclosurePanel class="w-full">
                    <form @submit.prevent="storeDepartment" class="space-y-4 mt-4">
                        <select v-model="form.category" class="w-full py-2 text-sm border-gray-300 rounded-md">
                            <option value="">Choose a category</option>
                            <option value="oversight">Oversight</option>
                            <option value="stock_management">Stock management</option>
                            <option value="treatment">Treatment</option>
                            <option value="setup">Setup</option>
                        </select>
                        <div v-if="form.errors.category" class="text-red-500 text-sm">A category is required</div>

                        <input type="text" v-model="form.name" placeholder="Department name" class="w-full py-2 text-sm border-gray-300 rounded-md" />
                        <div v-if="form.errors.name" class="text-red-500 text-sm">The department name is required</div>

                        <button type="submit" class="bg-black text-white text-sm px-3 py-2 rounded-md">Save</button>
                        </form>
                </DisclosurePanel>
            </Disclosure>
        </div>
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 mt-3">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table v-if="departments.length" class="min-w-full table-fixed divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                            <td>Department</td>
                            <td>Code_name</td>
                            <td>Category</td>
                            <td colspan="2"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <Department v-for="department in departments" :key="department.id" :department="department" />
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <Head title="Create department" />
</template>

<style scoped>
.bordered-table {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ccc;
}
.bordered-table td,
.bordered-table thead {
  padding: 8px 16px;
  border: 1px solid #ccc;
  text-align: left;
}
</style>
