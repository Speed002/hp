<script setup>
import { Cog8ToothIcon, CursorArrowRippleIcon } from '@heroicons/vue/20/solid'
import { Head, Link } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'

defineOptions({ layout: [Default, Account] })

defineProps({
    hospitals:Object
})
</script>

<template>
    <div v-if="$page.props.auth.user.permissions.manage_hospitals" class="max-w-7xl mx-auto space-y-2">
        <div>
            <h2 class="font-bold text-gray-900 font-mono flex items-center">
                Hospitals
            </h2>
            <span v-if="hospitals.length > 0" class="text-gray-500 tracking-tighter">Click settings to profile the hospital</span>
        </div>
        <div v-for="hospital in hospitals" class="px-4 py-4 rounded-md font-semibold text-sm border border-gray-300 tracking-tight hover:bg-blue-100 hover:cursor-pointer">
            {{ hospital.name }} [ <span class="text-blue-600 font-semibold text-sm">{{ hospital.users[0]?.name ?? 'No user' }}, {{ hospital.users[0]?.contact ?? 'No contact' }}, {{ hospital.users[0]?.email ?? 'No email' }}, {{hospital.address }}</span> ]
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center space-x-2 text-blue-900 mt-2">
                    <span v-for="department in hospital.departments" class="bg-blue-100 px-2 py-1 rounded-full text-xs">{{ department.name }}</span>
                </div>
                <div v-if="$page.props.auth.user.permissions.profile_hospitals" class="flex gap-5">
                    <Link v-if="$page.props.auth.user.permissions.update_hospital" :href="route('client.edit.hospital', `${hospital.id}`)" class="text-blue-900 font-semibold flex items-center gap-1 hover:cursor-pointer hover:text-blue-600">
                        <Cog8ToothIcon class="h-4 w-4"/>
                        <span class="mb-4">Settings</span>
                    </Link>
                    <Link :href="route('hospital.settings', `${hospital.id}`)" class="text-blue-900 font-semibold flex items-center gap-1 hover:cursor-pointer hover:text-blue-600">
                        <CursorArrowRippleIcon class="h-4 w-4"/>
                        <span class="mb-4">Profile</span>
                    </Link>
                </div>
            </div>
        </div>
    </div>
    <Head title="Dashboard" />
</template>

<style scoped>
.mb-4{
    margin-bottom: 4px;
}
</style>
