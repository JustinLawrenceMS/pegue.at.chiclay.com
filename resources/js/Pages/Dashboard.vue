<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Pegue.">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl lg:ml-80 lg:mr-80 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
    .bg-gray-100 {
        --tw-bg-opacity: 0 !important;
    }
</style>
