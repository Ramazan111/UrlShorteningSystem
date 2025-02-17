<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <GuestLayout>

      {{ message }}

    </GuestLayout>
</template>
