<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 dark:bg-purple-950 bg-purple-300 border-black shadow-md overflow-hidden rounded-3xl">
            <div>
                <slot name="logo" />
            </div>
            <slot />
        </div>
    </div>
</template>
<script setup lang="ts">
</script>
<style scoped>
    .border-black {
        border: 2px solid black;
    }
</style>
