<script setup>
import { Disclosure, DisclosurePanel, DisclosureButton } from '@headlessui/vue'
import { PlusCircleIcon, ChevronDownIcon } from '@heroicons/vue/20/solid'
import { Head, useForm } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'
import User from './User.vue'

defineOptions({ layout: [Default, Account] })
const props = defineProps({
    roles:Object,
    members:Object
})
const form = useForm({
    name: '',
    email:'',
    contact:'',
    role:''

})
const storeUser = () => {
    form.post(route('user.store'), {
        onSuccess: () => {
            form.reset()
        }
    })
}
</script>

<template>
<!-- {{ roles }} -->
<div v-if="$page.props.auth.user.permissions.create_users">
    <Disclosure as="nav" v-slot="{ open }">
        <DisclosureButton class="text-left flex items-center justify-between space-x-5 w-full">
            <div>
            <h2 class="font-bold text-gray-900 font-mono">Create new user.</h2>
            <span class="text-gray-500 tracking-tighter">Create new user with a role under this hospital.</span>
            </div>
            <div>
                <PlusCircleIcon v-if="!open" class="block h-6 w-6" />
                <ChevronDownIcon v-if="open" class="block h-6 w-6" />
            </div>
        </DisclosureButton>
        <DisclosurePanel class="w-full">
            <form v-on:submit.prevent="storeUser">
                <div class="flex items-center space-x-3">
                    <div class="w-72">
                        <label for="name" class="sr-only text-sm font-medium text-gray-900">Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="form.name" placeholder="Name">
                            <div class="text-sm text-red-500 mt-2">
                                {{ form.errors.name }}
                            </div>
                        </div>
                    </div>
                    <div class="w-72">
                        <label for="name" class="sr-only text-sm font-medium text-gray-900">Email</label>
                        <div class="mt-2">
                            <input type="text" name="email" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="form.email" placeholder="email@example.com">
                            <div class="text-sm text-red-500 mt-2">
                                {{ form.errors.email }}
                            </div>
                        </div>
                    </div>
                    <div class="w-72">
                        <label for="name" class="sr-only text-sm font-medium text-gray-900">Contact</label>
                        <div class="mt-2">
                            <input type="text" name="contact" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="form.contact" placeholder="contact">
                            <div class="text-sm text-red-500 mt-2">
                                {{ form.errors.contact }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-72">
                    <label for="name" class="sr-only">Role</label>
                    <select class="px-2 py-2 rounded-md w-full border-slate-300 text-slate-500 text-sm" v-model="form.role">
                        <option value="">Choose a role</option>
                        <option v-for="role in roles" :key="role.id" :value="role.name">
                            {{ role.name }}
                        </option>
                    </select>
                    <div class="text-sm text-red-500 mt-2">
                        {{ form.errors.role }}
                    </div>
                </div>
                </div>
                <div class="mt-3 space-x-6">
                    <div>
                        <button type="submit" class="flex justify-center bg-gray-900 px-3 py-2 text-sm font-semibold text-white disabled:opacity-50 rounded-md">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </DisclosurePanel>
    </Disclosure>
    <div class="header mt-3 mb-[100px]">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full py-2 align-middle">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="bordered-table shadow w-full text-sm">
                        <thead class="bg-gray-50 text-sm">
                            <tr>
                                <td>
                                    Name
                                </td>
                                <td>
                                    Email
                                </td>
                                <td>
                                    Contact
                                </td>
                                <td>
                                    Role
                                </td>
                                <td colspan="2">

                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <User v-for="member in members" :key="member.id" :member="member" :roles="roles"/>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <Head title="Profile information" />
</template>
