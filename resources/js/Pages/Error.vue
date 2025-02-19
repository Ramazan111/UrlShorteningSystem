<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';

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
