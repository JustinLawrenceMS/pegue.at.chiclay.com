<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link :href="'/'">
        <div class="md:text-9xl text-4xl text-black flex items-center justify-between">
            <p>Pegue.</p>
            <p>&nbsp;</p>
        </div>
    </Link>
</template>
<style scoped>
    .text-gray-400 {
        text-shadow: -1px -1px 0 #000,
        1px -1px 0 #000,
        -1px 1px 0 #000,
        1px 1px 0 #000;
    }
</style>
