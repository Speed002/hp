<script setup>
import { useForm, Head } from '@inertiajs/vue3'
import { watch } from 'vue'

const props = defineProps({
  permission: Object,
  role: Object,
  role_has_permissions: Array,
})

// Determine if the checkbox should be initially checked
const alreadyHasPermission = props.role_has_permissions.some(
  item => item.role_id === props.role.id && item.permission_id === props.permission.id
)

const form = useForm({
  checked: alreadyHasPermission,
})

watch(
  () => form.checked,
  (newValue, oldValue) => {
    if (newValue === true) {
      form.post(route('permission.add', [props.role.id, props.permission.id]), {
        preserveScroll: true,
      })
    } else {
      form.delete(route('permission.remove', [props.role.id, props.permission.id]), {
        preserveScroll: true,
      })
    }
  }
)
</script>

<template>
  <div
    class="w-fit mb-2 rounded-t-lg bg-blue-100 px-2 py-2 text-left text-sm text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring focus-visible:ring-purple-500/75 hover:cursor-pointer"
  >
    <div class="flex items-center">
      <input
        type="checkbox"
        v-model="form.checked"
        :id="`perm-${permission.id}`"
        class="h-4 w-4 text-blue-500 focus:ring-blue-500 rounded-md hover:cursor-pointer"
      />
      <label
        :for="`perm-${permission.id}`"
        class="ml-2 block text-blue-900 hover:cursor-pointer"
      >
        {{ permission.name }}
      </label>
    </div>
  </div>

  <Head title="Permissions" />
</template>
