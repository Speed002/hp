<script setup>
import { ref, watch } from 'vue';
import { Link, usePage, useForm, router } from '@inertiajs/vue3'
import debounce from 'lodash.debounce';

const props = defineProps({
    service:Object
})

const editting = ref(false)

const editForm = useForm({
    name:props.service.name,
})

const editService = debounce(() => {
    editForm.patch(route('service.edit', props.service.id), {
        preserveScroll:true
    })
}, 500)

watch(() => editForm.isDirty, () => {
        editService()
})

const deleteService = () => {
    if(confirm("Please cconfirm to delete?")){
        router.delete(route('service.destroy', `${props.service.id}`), {
            preserveScroll:true
        })
    }
}
</script>

<template>
    <tr>
        <td scope="col" class="min-w-[15rem] text-left text-sm text-gray-900">
            <template v-if="editting">
                <input v-model="editForm.name" type="text" class="text-sm rounded-md min-w-[11rem] border-gray-400 py-1"/>
            </template>
            <template v-else>
                <span class="font-semibold">{{service.name}}</span>
            </template>
        </td>
        <td scope="col" class="italic text-left text-sm text-gray-900">
            {{service.code_name}}
        </td>
        <td scope="col" class="min-w-[5rem] px-3 text-left text-sm text-blue-500">
            <template v-if="editting">
                <button @click="editting = false" class="text-indigo-600 hover:text-indigo-900">
                   Done
                </button>
            </template>
            <template v-else>
                <button @click="editting = true" class="text-indigo-600 hover:text-indigo-900">
                   Edit
                </button>
            </template>
        </td>
        <td scope="col" class="px-3 text-left text-sm text-rose-500">
            <button @click="deleteService">Remove</button>
        </td>
    </tr>
</template>
