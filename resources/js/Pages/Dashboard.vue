<script setup>
import { Head } from '@inertiajs/vue3'
import Default from '@/Layouts/Default.vue'
import Account from '@/Layouts/Account.vue'

defineOptions({ layout: [Default, Account] })
</script>

<template>
    <div class="max-w-7xl mx-auto">
        <!-- {{ $page.props.current_hospital_services }} -->
        Dashboard
    </div>
    <Head title="Dashboard" />
</template>
