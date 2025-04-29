<script setup>
import { Disclosure, DisclosurePanel, DisclosureButton } from '@headlessui/vue'
import { PlusCircleIcon, ChevronDownIcon } from '@heroicons/vue/20/solid'

import{ Head, useForm } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'
import Role from '@/Pages/Hospital/Role/Role.vue'

defineOptions({ layout: [Default, Account] })
defineProps({
    hospital_user_roles:Object,
    permissions:Object,
    role_has_permissions:Object
})

const createForm = useForm({
    role_name:''
})

const createRole = () => {
    createForm.post(route('admin.store.role'), {
        preserveScroll:true,
        onSuccess: () => {
            createForm.reset()
        }
    });
}

</script>

<template>
        <div>
            <!-- {{roles}} -->
            <Disclosure as="nav" v-slot="{ open }">
                <DisclosureButton class="text-left flex items-center justify-between w-full">
                    <div>
                        <h2 class="font-bold text-gray-900 font-mono">Create roles and assign permissions to them.</h2>
                        <span class="text-gray-500 tracking-tighter"> Default services and existing services in selected departments show, incase of any missing service, check your department.</span>
                    </div>
                    <div>
                        <PlusCircleIcon v-if="!open" class="block h-6 w-6" />
                        <ChevronDownIcon v-if="open" class="block h-6 w-6" />
                    </div>
                </DisclosureButton>
                <DisclosurePanel class="w-full">
                    <form v-on:submit.prevent="createRole">
                        <div class="space-y-2 w-96">
                            <div class="flex flex-col gap-3 mt-5">
                                <div>
                                    <label for="role" class="sr-only text-sm font-medium text-gray-900">Role</label>
                                    <div>
                                        <input type="text" v-model="createForm.role_name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" placeholder="Add missing role eg. Doctor">
                                        <div v-if="createForm.errors.role_name" class="text-sm text-red-500 mt-2">
                                            {{createForm.errors.role_name}}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="bg-black px-3 py-2 text-sm font-semibold text-white rounded-md disabled:opacity-50">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </DisclosurePanel>
            </Disclosure>
        </div>
        <div>
            <div class="flex items-start justify-between">
                <div v-if="hospital_user_roles.length > 0" class="w-full flex justify-start space-x-5 overflow-x-auto">
                    <div v-for="role in hospital_user_roles" :key="role.id" class="department my-3 mb-20">
                        <Role :role="role" :permissions="permissions" :role_has_permissions="role_has_permissions"/>
                    </div>
                </div>
            </div>
        </div>
    <Head title="Assign permission to role" />
</template>
