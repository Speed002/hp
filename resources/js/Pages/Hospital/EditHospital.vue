<script setup>
import { Head, usePage, useForm, Link } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'
import { ChevronLeftIcon } from '@heroicons/vue/20/solid'

defineOptions({ layout: [Default, Account] })

const props = defineProps({
    hospital:Object
})

const page = usePage()
const hospital = props.hospital
const user = props.hospital.users[0]

const form = useForm({
    id:hospital.id,
    name:hospital.name,
    address:hospital.address
})

const userForm = useForm({
    admin_username:user.name,
    admin_email:user.email,
    admin_contact:user.contact
})

const updateHospital = () => {
    form.patch(route('client.update.hospital', `${props.hospital.id}`), {
        preserveScroll: true
    })
}

const updateAdmin = () => {
    userForm.patch(route('update.hospital.admin', `${user.id}`), {
        preserveScroll: true
    })
}
</script>

<template>
    <div v-if="$page.props.auth.user.permissions.update_hospital" class="w-96">
        <h2 class="font-bold text-gray-900 tracking-tighter">Hospital information for {{hospital.name}}</h2>
        <!-- {{ page.props.auth.user.permissions.update_hospital }} -->
        <div class="space-y-6">
            <div v-if="$page.props.auth.user.permissions.update_hospital" class="w-96 space-y-6">
                <div>
                    <span class="text-gray-500 tracking-tighter">Update your hospital's information</span>

                    <Link :href="route('hospital.index')" class="flex items-center my-3 text-indigo-600 text-sm font-semibold">
                        <ChevronLeftIcon class="block h-6 w-6 -ml-2" />
                        <span>Go back</span>
                    </Link>

                    <form v-on:submit.prevent="updateHospital">
                        <div>
                            <label for="name" class="text-sm font-medium font-semibold tracking-tight text-gray-900">Hospital name</label>
                            <div class="mt-2">
                                <input type="text" name="name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="form.name">
                                <div v-if="form.errors.name" class="text-sm text-red-500 mt-2">
                                    {{ form.errors.name }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="name" class="text-sm font-medium font-semibold tracking-tight text-gray-900">Hospital name</label>
                            <div class="mt-2">
                                <input type="text" name="name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="form.address">
                                <div v-if="form.errors.address" class="text-sm text-red-500 mt-2">
                                    {{ form.errors.address }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="mt-3 rounded-md flex justify-center bg-blue-500 px-3 py-2 text-sm font-semibold text-white disabled:opacity-50" :disabled="form.processing">
                                Update
                            </button>
                        </div>
                    </form>
                </div>

                <div>
                    <span class="text-gray-500 tracking-tighter">Update hospital admin profile</span>
                    <form v-on:submit.prevent="updateAdmin" class="space-y-4">
                        <div>
                            <label for="name" class="text-sm font-medium font-semibold tracking-tight text-gray-900">Admin username</label>
                            <div class="mt-2">
                                <input type="text" name="name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="userForm.admin_username">
                                <div v-if="userForm.errors.admin_username" class="text-sm text-red-500 mt-2">
                                    {{ userForm.errors.admin_username }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="name" class="text-sm font-medium font-semibold tracking-tight text-gray-900">Admin email</label>
                            <div class="mt-2">
                                <input type="text" name="name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="userForm.admin_email">
                                <div v-if="userForm.errors.admin_email" class="text-sm text-red-500 mt-2">
                                    {{ userForm.errors.admin_email }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="name" class="text-sm font-medium font-semibold tracking-tight text-gray-900">Admin contact</label>
                            <div class="mt-2">
                                <input type="text" name="name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="userForm.admin_contact">
                                <div v-if="userForm.errors.admin_contact" class="text-sm text-red-500 mt-2">
                                    {{ userForm.errors.admin_contact }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="mt-3 rounded-md flex justify-center bg-blue-500 px-3 py-2 text-sm font-semibold text-white disabled:opacity-50" :disabled="form.processing">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <Head title="Edit Hospital" />
</template>

