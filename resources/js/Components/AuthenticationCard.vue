<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-purple-950 border-black shadow-md overflow-hidden sm:rounded-lg">
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
