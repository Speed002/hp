<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import debounce from 'lodash.debounce';

const editting = ref(false)

const props = defineProps({
    member:Object,
    roles:Object
})

const updateForm = useForm({
    name: props.member.name,
    email: props.member.email,
    contact: props.member.contact,
    role: props.member.role || '' // <-- this is important
});

const updateUser = debounce(() => {
    updateForm.patch(route('user.role.edit', props.member.id), {
        preserveScroll:true
    })
}, 500)

watch(() => updateForm.isDirty, () => {
    if(updateForm.isDirty == true){
        updateUser()
    }
})

const deleteUser = () => {
    if(confirm('Please confirm to delete?')){
        router.delete(route('user.role.destroy', props.member.id), {
            preserveScroll:true
        })
    }
}
</script>

<template>
        <tr class="text-gray-600">
            <td class="w-[200px]">
                <template v-if="editting">
                    <input type="text" v-model="updateForm.name" class="text-sm rounded-md border-gray-400 py-0.5 px-1 w-[150px]"/>
                </template>
                <template v-else>
                    {{ member.name }}
                </template>
            </td>
            <td class="w-[180px]">
                <template v-if="editting">
                    <input type="text" v-model="updateForm.email" class="text-sm rounded-md border-gray-400 py-0.5 w-[130px]"/>
                </template>
                <template v-else>
                    {{ member.email }}
                </template>
            </td>
            <td class="w-[180px]">
                <template v-if="editting">
                    <input type="text" v-model="updateForm.contact" class="text-sm rounded-md border-gray-400 py-0.5 w-[130px]"/>
                </template>
                <template v-else>
                    {{ member.contact }}
                </template>
            </td>
            <td class="w-[190px]">
                <template v-if="editting">
                    <select
                        v-model="updateForm.role"
                        name="role"
                        class="w-[150px] text-gray-900 border border-gray-300 rounded-md text-sm py-1 px-2">
                        <option disabled value="">{{ props.member.role ?? 'Choose role' }}</option>
                        <option
                            v-for="role in roles"
                            :key="role.id"
                            :value="role.id"
                        >
                            {{ role.name }}
                        </option>
                    </select>
                </template>
                <template v-else>
                    {{ member.role || '[no role]' }}
                </template>
            </td>

            <td class="text-sm flex justify-between">
                <template v-if="editting">
                    <button @click="editting = false" href="#" class="text-indigo-600 hover:text-indigo-900 text-sm py-1 px-0">
                        Done
                    </button>
                </template>
                <template v-else>
                    <button @click="editting = true" href="#" class="text-indigo-600 hover:text-indigo-900 text-sm py-1 px-0">
                        Edit
                    </button>
                </template>
                <button v-on:click="deleteUser()" class="text-rose-600 rounded-md">Delete</button>
            </td>
        </tr>
</template>
