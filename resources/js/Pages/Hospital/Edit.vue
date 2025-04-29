<script setup>
import { Head, usePage, useForm } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'

defineOptions({ layout: [Default, Account] })

const page = usePage()
const hospital = page.props.auth.user.current_hospital
const user = page.props.auth.user

const form = useForm({
    id:hospital.id,
    name:hospital.name,
    address:hospital.address,
    contact: user.contact
})

const updateHospital = () => {
    form.patch(route('hospital.update'), {
        preserveScroll: true
    })
}
</script>

<template>
    <div class="w-96">
        <!-- {{user.contact}} -->
        <h2 class="font-bold text-gray-900 tracking-tighter">Hospital information</h2>
        <!-- {{ page.props.auth.user.permissions.update_hospital }} -->
        <div class="space-y-6">
            <div v-if="$page.props.auth.user.permissions.update_hospital" class="w-96">
                <!-- <h2 class="font-bold text-gray-900 font-mono">Update team information</h2> -->
                <span class="text-gray-500 tracking-tighter">Update your hospital's information</span>
                <form v-on:submit.prevent="updateHospital(form.id)" class="space-y-3">
                    <div>
                        <label for="name" class="text-sm font-semibold tracking-tight font-medium text-gray-600">Hospital name</label>
                        <div class="mt-2">
                            <input type="text" name="name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="form.name">
                            <div v-if="form.errors.name" class="text-sm text-red-500 mt-2">
                                {{ form.errors.name }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="name" class="text-sm font-semibold tracking-tight font-medium text-gray-600">Hospital address</label>
                        <div class="mt-2">
                            <input type="text" name="name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="form.address">
                            <div v-if="form.errors.address" class="text-sm text-red-500 mt-2">
                                {{ form.errors.address }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="name" class="text-sm font-semibold tracking-tight font-medium text-gray-600">Hospital contact</label>
                        <div class="mt-2">
                            <input type="text" name="name" class="w-full py-2 text-gray-900 border-gray-300 text-sm rounded-md" v-model="form.contact">
                            <div v-if="form.errors.contact" class="text-sm text-red-500 mt-2">
                                {{ form.errors.contact }}
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
    <Head title="Hospital Profile" />
</template>
