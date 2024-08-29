<template>
    <AppLayout title="Add Citation">
        <pegue-create>
        </pegue-create>
    </AppLayout>
</template>
<script setup lang="ts">
import PegueCreate from "@/Components/pegue/pegue-create.vue";
import {defineComponent} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

defineComponent({
    components: {
        PegueCreate
    }
})
</script>
