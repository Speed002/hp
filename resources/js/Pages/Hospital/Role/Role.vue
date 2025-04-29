<script setup>
import { router } from '@inertiajs/vue3'
import { MinusCircleIcon } from '@heroicons/vue/20/solid'
import Permission from './Permission.vue'

const props = defineProps({
    role:Object,
    permissions:Object,
    role_has_permissions:Object
})
const removeRole = () => {
    if(confirm("You are about to delete this role, Please confirm to proceed!")){
        router.delete(route('role.destroy', `${props.role.id}`),{
            preserveScroll:true
        })
    }
}
</script>
<template>
    <div >
        <form v-on:submit.prevent="removeRole">
            <div class="flex items-center justify-between -space-x-6">
                <span class="text-gray-600 tracking-tighter text-sm w-64">Select services for the role: <span class="font-bold">{{role.name}}</span></span>
                <button v-if="role.name != 'hospital admin'" type="submit">
                    <MinusCircleIcon class="block h-6 w-6 text-rose-500" />
                </button>
            </div>
        </form>
    </div>
    <hr>
    <!-- Only displays for super admin to profile hospital admin created along with the hospital 2 checks for validation -->
    <div v-if="$page.props.auth.user.permissions.manage_roles_and_permissions">
        <!-- display to the super admin only, so they can profile the hospital admin -->
        <div v-if="role.name == 'hospital admin'" class="space-y-3 mt-3">
            <Permission v-for="permission in permissions" :key="permission.id" :permission="permission" :role="role" :role_has_permissions="role_has_permissions"/>
        </div>
    </div>
    <div v-if="$page.props.auth.user.permissions.assign_roles_and_permissions">
        <!-- Display to the hospital admin only, so they can profile their other user roles within the hospital, the hospital admin should never be able profile themselves as hospital admins, they can only profle other users within their hospital and within the range of permissions we are giving them -->
        <div v-if="role.name != 'hospital admin'" class="space-y-3 mt-3">
            <Permission v-for="permission in permissions" :key="permission.id" :permission="permission" :role="role" :role_has_permissions="role_has_permissions"/>
        </div>
    </div>
</template>
