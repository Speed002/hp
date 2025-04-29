<script setup>
import { Disclosure, DisclosurePanel, DisclosureButton } from '@headlessui/vue'
import { PlusCircleIcon, ChevronDownIcon } from '@heroicons/vue/20/solid'

import { Head, useForm, usePage, Link } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'
import Role from './Role.vue'

defineOptions({ layout: [Default, Account] })

defineProps({
    roles:Object,
    permissions:Object,
    role_has_permissions:Object
})

const roleForm = useForm({
    name:''
})

const storeRole = () => {
    roleForm.post(route('roles.store'), {
        preserveScroll:true,
        onSuccess: () => {
            roleForm.reset()
        }
    })
}
</script>

<template>
        <div>
            <Disclosure as="nav" v-slot="{ open }">
                <DisclosureButton class="text-left flex items-center justify-between space-x-5 w-full">
                    <div>
                        <h2 class="font-bold text-gray-900 font-mono">Manage roles and permissions</h2>
                        <span v-if="$page.props.auth.user.permissions.assign_roles_and_permissions"  class="text-gray-500 tracking-tighter">Note: Assign permissions to roles and add roles</span>
                        <span v-if="$page.props.auth.user.permissions.manage_roles_and_permissions" class="text-gray-500 tracking-tighter">Note: Super admin may not assign permissions to any other user except hospital admin</span>
                    </div>
                    <div v-if="$page.props.auth.user.permissions.assign_roles_and_permissions">
                        <PlusCircleIcon v-if="!open" class="block h-6 w-6" />
                        <ChevronDownIcon v-if="open" class="block h-6 w-6" />
                    </div>
                </DisclosureButton>
                <DisclosurePanel class="w-full">
                    <form v-on:submit.prevent="storeRole" v-if="$page.props.auth.user.permissions.assign_roles_and_permissions">
                        <div class="space-y-2 w-96">
                            <div class="flex flex-col gap-3 mt-5">
                                <div>
                                    <label for="role" class="sr-only text-sm font-medium text-gray-900">Role</label>
                                    <div>
                                        <input type="text" name="name" v-model="roleForm.name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" placeholder="Add missing role eg. Doctor">
                                        <div v-if="roleForm.errors.name" class="text-sm text-red-500 mt-2">
                                            {{roleForm.errors.name}}
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
                <div v-if="roles.length > 0" class="w-full flex justify-start space-x-5 overflow-x-auto">
                    <div v-for="role in roles" :key="role.id" class="department my-3 mb-20">
                        <Role :role="role" :permissions="permissions" :role_has_permissions="role_has_permissions"/>
                    </div>
                </div>
            </div>
        </div>
    <Head title="Roles and permissions" />
</template>
