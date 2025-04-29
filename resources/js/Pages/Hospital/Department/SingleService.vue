<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref, watch, computed } from 'vue'

const props = defineProps({
  hospital: Object,
  service: Object,
  department: Object,
  department_services: Array
})

// Set initial selected services from department_services
const form = useForm({
  name: props.department_services.map(s => s.service_id)
})

// Store the previous state of checked services
const previousServices = ref([...form.name])

// Watch for changes in selected services
watch(
  () => [...form.name],
  (newVal, oldVal) => {
    const removed = oldVal.filter(id => !newVal.includes(id))
    const added = newVal.filter(id => !oldVal.includes(id))

    if (added.length) {
      // Service(s) added — hit add route
      added.forEach(serviceId => {
        form.post(route('add.service', [props.hospital.id, props.department.id, serviceId]), {
          preserveScroll: true,
        })
      })
    }

    if (removed.length) {
      // Service(s) removed — hit remove route
      removed.forEach(serviceId => {
        form.delete(route('remove.service', [props.hospital.id, props.department.id, serviceId]), {
          preserveScroll: true,
        })
      })
    }

    previousServices.value = [...newVal] // update previous
  },
  { deep: true }
)

</script>

<template>
    <div v-if="service.department_id == department.id" class="w-fit mb-2 rounded-t-lg bg-blue-100 px-2 py-2 text-left text-sm text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring focus-visible:ring-purple-500/75 hover:cursor-pointer">
        <div class="flex items-center">
            <input type="checkbox" v-model="form.name" :value="service.id" class="h-4 w-4 text-blue-500 focus:ring-blue-500 rounded-md hover:cursor-pointer">
            <label for="remember" class="ml-2 block text-blue-900 hover:cursor-pointer">{{service.name}}</label>
        </div>
    </div>
</template>
