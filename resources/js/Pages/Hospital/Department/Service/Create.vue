<script setup>
import { Disclosure, DisclosurePanel, DisclosureButton } from '@headlessui/vue'
import { PlusCircleIcon, ChevronDownIcon, ChevronLeftIcon } from '@heroicons/vue/20/solid'

import { useForm, Link, Head } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'
import Service from './Service.vue'

defineOptions({ layout: [Default, Account] })

const props = defineProps({ department: Object })

const form = useForm({ name: '' })

const storeService = () => {
  form.post(route('service.store', props.department.id), {
    onSuccess: () => form.reset()
  })
}
</script>

<template>
    <div>
      <Disclosure as="nav" v-slot="{ open }">
        <DisclosureButton class="flex items-center justify-between w-full space-x-5 text-left">
          <div>
            <h2 class="font-bold text-gray-900 font-mono">Create service under {{ department.name }}</h2>
            <span class="text-blue-600 text-sm">Creating or removing services also affects permissions.</span>
          </div>
          <div>
            <PlusCircleIcon v-if="!open" class="h-6 w-6" />
            <ChevronDownIcon v-else class="h-6 w-6" />
          </div>
        </DisclosureButton>

        <DisclosurePanel class="mt-4">
          <form @submit.prevent="storeService" class="w-[600px] space-y-4">
            <div>
              <input
                v-model="form.name"
                type="text"
                placeholder="Service"
                class="w-full py-2 border-gray-300 rounded-md text-sm text-gray-900"
              />
              <div v-if="form.errors.name" class="text-sm text-red-500 mt-1">{{ form.errors.name }}</div>
            </div>
            <button
              type="submit"
              class="bg-black text-white px-3 py-2 text-sm font-semibold rounded-md disabled:opacity-50"
            >
              Save
            </button>
          </form>
        </DisclosurePanel>
      </Disclosure>

      <Link :href="route('department.create')" class="flex items-center mt-3 text-indigo-600 text-sm font-semibold">
        <ChevronLeftIcon class="h-6 w-6 -ml-2" />
        <span>Go back</span>
      </Link>

      <div v-if="department.services.length" class="mt-6 w-[690px] mb-[100px]">
        <div class="overflow-x-auto">
          <div class="inline-block min-w-full py-2 align-middle">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
              <table class="bordered-table text-sm">
                <thead class="bg-gray-50">
                  <tr>
                    <td>Service</td>
                    <td>Code_name</td>
                    <td colspan="2"></td>
                  </tr>
                </thead>
                <tbody>
                  <Service v-for="service in department.services" :key="service.id" :service="service" />
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="text-gray-500 mt-4">No services registered.</div>
      <Head title="Create service" />
    </div>
  </template>


<style>
    .bordered-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ccc;
    }
    .bordered-table thead, .bordered-table td, tbody tr, td {
    padding: 8px 16px;
    border: 1px solid #ccc;
    text-align: left;
    }
</style>
