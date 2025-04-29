<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/24/outline'
const page = usePage()

const permissions_service_list = page.props.auth.user.permissions_service_list ?? null
const user_department_list = page.props.auth.user.user_department_list ?? null
</script>

<template>
        <div class="mx-auto max-w-6xl sm:grid grid-cols-5 space-y-8 mt-20 sm:space-y-0">
            <div class="col-span-1">
                <nav class="border-r border-r-slate-200 h-full md:px-0 sm:px-8 px-8 lg:block md:block sm:hidden hidden lg:mx-0 md:mx-3">
                    <ul class="space-y-3">
                        <li>
                            <Link :href="route('dashboard')" class="text-gray-900 flex text-sm font-semibold" :class="{ 'text-blue-600 font-semibold': $page.props.ziggy.route_name === 'dashboard' }">
                                Dashboard
                            </Link>
                        </li>
                        <!-- this section is not for who is managing hospitals(super admin) and is not for who is profiling a hospital(hospital admin)-->
                        <div v-if="!$page.props.auth.user.permissions.manage_hospitals && !$page.props.auth.user.permissions.profile_hospital" class="space-y-3">
                            <li v-for="department in $page.props.auth.user.current_hospital.departments">
                                <div v-if="user_department_list && user_department_list.includes(department.id)">
                                    <Disclosure v-slot="{ open }">
                                        <DisclosureButton class="text-gray-900 flex text-sm font-semibold w-full">
                                            <div class="flex items-center justify-start w-full">
                                                <span class="pr-3">{{department.name}}</span>
                                                <ChevronDownIcon v-if="!open" class="w-4 h-4"/>
                                                <ChevronUpIcon v-if="open" class="w-4 h-4"/>
                                            </div>
                                        </DisclosureButton>
                                        <DisclosurePanel v-for="service in department.services" class="text-gray-500 flex flex-col">
                                                <!-- show the link based on whether the permission is existent -->
                                                <div v-if="permissions_service_list && permissions_service_list.includes(service.name)">
                                                    <Link :href="route(`${service.code_name}`)" class="text-sm font-normal">
                                                        {{service.name}}
                                                    </Link>
                                                </div>
                                        </DisclosurePanel>
                                    </Disclosure>
                                </div>
                            </li>
                        </div>

                        <li v-if="$page.props.auth.user.permissions.manage_departments">
                            <Link :href="route('department.create')" class="text-gray-900 flex text-sm font-semibold">
                                Create and manage departments
                            </Link>
                        </li>
                        <!-- manage roles and permissions -->
                        <li v-if="$page.props.auth.user.permissions.manage_roles_and_permissions">
                            <Link :href="route('manage.roles')" class="text-gray-900 flex text-sm font-semibold">
                                Roles and permissions
                            </Link>
                        </li>

                        <li v-if="$page.props.auth.user.permissions.manage_hospitals">
                            <Disclosure v-slot="{ open }">
                                <DisclosureButton class="text-gray-900 flex text-sm font-semibold w-full">
                                    <div class="flex items-center justify-start w-full">
                                        <span class="pr-3">Manage hospitals</span>
                                        <ChevronDownIcon v-if="!open" class="w-4 h-4"/>
                                        <ChevronUpIcon v-if="open" class="w-4 h-4"/>
                                    </div>
                                </DisclosureButton>
                                <DisclosurePanel class="text-gray-500 flex flex-col pt-1 space-y-1">
                                    <Link :href="route('hospital.create')" class="text-sm font-normal">
                                        Create hospital
                                    </Link>
                                    <Link :href="route('hospital.index')" class="text-sm font-normal">
                                        View hospitals
                                    </Link>
                                </DisclosurePanel>
                            </Disclosure>
                        </li>


                        <!-- Second Dropdown  - manage users-->
                        <li v-if="$page.props.auth.user.permissions.create_users">
                            <Link :href="route('user.create')" class="text-gray-900 flex text-sm font-semibold">
                                Manage users
                            </Link>
                        </li>
                        <li v-if="$page.props.auth.user.permissions.assign_roles_and_permissions">
                            <Link :href="route('assign.permissions.to.roles')" class="text-gray-900 flex text-sm font-semibold">
                                Assign permissions to roles
                            </Link>
                        </li>
                        <li v-if="$page.props.auth.user.permissions.profile_hospital">
                            <Link :href="route('hospital.settings', `${$page.props.auth.user.current_hospital.id}`)" class="text-gray-900 flex text-sm font-semibold">
                                Hospital profile
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="lg:col-span-4 md:col-span-4 sm:col-span-5 lg:px-3 md:px-3 sm:px-8 px-8">
                <slot />
            </div>
        </div>
</template>
