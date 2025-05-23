<script setup>
import { Link, router } from '@inertiajs/vue3'
import { Disclosure, DisclosurePanel, DisclosureButton, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon, ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/24/outline'

const logout = () => {
    router.post(route('logout'))
}
</script>

<template>
    <div class="fixed top-0 w-full bg-white">
    <Disclosure as="nav" class="border-b border-b-slate-200" v-slot="{ open }">
        <div class="mx-auto max-w-6xl">
            <div class="flex h-16 justify-between relative md:px-0 sm:px-8 px-8">
                <div class="flex grow">
                    <div class="flex items-center sm:mr-6 lg:mx-0 md:mx-3">
                        <Link href="#" class="font-bold font-mono text-lg">
                            {{ $page.props.config['app.name'] }}
                        </Link>
                    </div>
                </div>

                <div class="absolute inset-y-0 right-0 flex items-center space-x-3">
                    <Menu as="div" class="relative mr-3"  v-if="!$page.props.auth.user">
                        <MenuButton v-slot="{ open }" class="flex items-center text-sm space-x-3">
                            <span class="font-medium text-gray-500">
                                Account
                            </span>
                            <span>
                                <ChevronDownIcon v-if="!open" class="w-4 h-4"/>
                                <ChevronUpIcon v-if="open" class="w-4 h-4"/>
                            </span>
                        </MenuButton>
                        <MenuItems class="absolute right-0 z-10 mt-2 w-48 bg-white border border-b-slate-200 focus:outline-none rounded-md">
                            <MenuItem v-slot="{ active }">
                                <Link :href="route('auth.register')" class="block px-4 py-2 text-sm text-gray-500 w-full text-left font-semibold" :class="{ 'bg-gray-100': active }">
                                    Register
                                </Link>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <Link :href="route('auth.login')" class="block px-4 py-2 text-sm text-gray-500 w-full text-left font-semibold" :class="{ 'bg-gray-100': active }">
                                    Login
                                </Link>
                            </MenuItem>
                        </MenuItems>
                    </Menu>

                    <Menu as="div" class="relative mr-3" v-if="$page.props.auth.user">
                        <MenuButton v-slot="{ open }" class="flex items-center text-sm space-x-3">
                            <span class="font-medium text-gray-500">
                                {{ $page.props.auth.user.current_hospital.name }}
                            </span>
                            <span>
                                <ChevronDownIcon v-if="!open" class="w-4 h-4"/>
                                <ChevronUpIcon v-if="open" class="w-4 h-4"/>
                            </span>
                        </MenuButton>
                        <MenuItems class="absolute right-0 z-10 mt-2 w-48 bg-white border border-b-slate-200 focus:outline-none rounded-md">
                            <MenuItem v-slot="{ active }">
                                <Link :href="route('hospital.edit')" class="block px-4 py-2 text-sm text-gray-500 w-full text-left font-semibold" :class="{ 'bg-gray-100': active }">
                                    Hospital settings
                                </Link>
                            </MenuItem>
                        </MenuItems>
                    </Menu>

                    <Menu as="div" class="relative mr-3" v-if="$page.props.auth.user">
                        <MenuButton class="flex items-center text-sm space-x-3">
                            <span class="font-medium text-gray-900">
                                {{ $page.props.auth.user.name }}
                            </span>
                            <img :src="$page.props.auth.user.avatar_url" class="h-8 w-8 rounded-full">
                        </MenuButton>
                        <MenuItems class="absolute right-0 z-10 mt-2 w-48 bg-white border border-b-slate-200 focus:outline-none">
                            <MenuItem v-slot="{ active, close }" v-if="$page.props.features['update-profile-information']">
                                <Link :onSuccess="close" :href="route('account.index')" class="block px-4 py-2 text-sm text-gray-900" :class="{ 'bg-gray-100': active }">
                                    Account
                                </Link>
                            </MenuItem>
                            <MenuItem v-slot="{ active, close }" v-if="$page.props.features.security">
                                <Link :onSuccess="close" :href="route('account.security.index')" class="block px-4 py-2 text-sm text-gray-900" :class="{ 'bg-gray-100': active }">
                                    Security
                                </Link>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <button v-on:click="logout" class="block px-4 py-2 text-sm text-gray-900 w-full text-left" :class="{ 'bg-gray-100': active }">
                                    Sign out
                                </button>
                            </MenuItem>
                        </MenuItems>
                    </Menu>

                    <DisclosureButton class="sm:hidden relative p-2 text-gray-900 hover:bg-gray-100">
                        <Bars3Icon v-if="!open" class="block h-6 w-6" />
                        <XMarkIcon v-if="open" class="block h-6 w-6" />
                    </DisclosureButton>
                </div>
            </div>
        </div>

        <DisclosurePanel class="sm:hidden">
            <div class="spacey-1 pb-3">
                <Link :href="route('home')" class="block py-2 px-8 font-medium text-gray-900 border-l-2 border-transparent" :class="{ 'border-blue-500': $page.props.ziggy.route_name === 'home' }">
                    Home
                </Link>
                <Link :href="route('dashboard')" class="block py-2 px-8 font-medium text-gray-900 border-l-2 border-transparent" :class="{ 'border-blue-500': $page.props.ziggy.route_name === 'dashboard' }">
                    Dashboard
                </Link>
            </div>
            <div class="spacey-1 pb-3" v-if="!$page.props.auth.user">
                <Link :href="route('auth.register')" class="block py-2 px-8 font-medium text-gray-900" v-if="$page.props.features.registration">
                    Create an account
                </Link>
                <Link :href="route('auth.login')" class="block py-2 px-8 font-medium text-gray-900">
                    Sign in
                </Link>
            </div>
        </DisclosurePanel>
    </Disclosure>
</div>
</template>
