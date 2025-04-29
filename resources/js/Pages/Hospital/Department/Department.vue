<script setup>
import { ref, watch } from 'vue';
import { Link, usePage, useForm, router } from '@inertiajs/vue3'
import debounce from 'lodash.debounce';

const props = defineProps({
    department:Object
})

const editting = ref(false)

const editForm = useForm({
    name:props.department.name,
    category:props.department.category
})

const editDepartment = debounce(() => {
    editForm.patch(route('department.edit', props.department.id), {
        preserveScroll:true
    })
}, 500)

watch(() => editForm.isDirty, () => {
        editDepartment()
})

const deleteDepartment = () => {
    if(confirm('Please confirm to delete?')){
        router.delete(route('department.destroy', `${props.department.id}`), {
            preserveScroll:true
        })
    }
}
</script>

<template>
    <tr>

        <td scope="col" class="whitespace-nowrap min-w-[15rem] text-left text-sm text-gray-900">
            <template v-if="editting">
                <input v-model="editForm.name" type="text" class="text-sm rounded-md min-w-[11rem] border-gray-400 py-1"/>
            </template>
            <template v-else>
                <Link :href="route('department.service', department)" class="font-semibold hover:text-indigo-500">
                    {{department.name}}
                </Link>
            </template>
        </td>
        <td scope="col" class="italic text-left text-sm text-gray-900">
            {{department.code_name}}
        </td>
        <td scope="col" class="min-w-[15rem] italic text-left text-sm text-gray-900">
            <template v-if="editting">

                    <select name="category" class="min-w-[12rem] text-gray-900 border-gray-400 text-sm rounded-md py-1" v-model="editForm.category">
                        <option :value="editForm.category">{{editForm.category}}</option>
                        <option value="oversight">Oversight</option>
                        <option value="stock_management">Stock management</option>
                        <option value="treatment">Treatment</option>
                    </select>
            </template>
            <template v-else>
                {{department.category}}
            </template>
        </td>
        <td scope="col" class="min-w-[5rem] px-3 text-left text-sm text-blue-500">
            <template v-if="editting">
                <button @click="editting = false" href="#" class="text-indigo-600 hover:text-indigo-900">
                   Done
                </button>
            </template>
            <template v-else>
                <button @click="editting = true" href="#" class="text-indigo-600 hover:text-indigo-900">
                   Edit
                </button>
            </template>
        </td>
        <td scope="col" class="px-3 text-left text-sm text-rose-500">
            <button @click="deleteDepartment">Remove</button>
        </td>
    </tr>
</template>
