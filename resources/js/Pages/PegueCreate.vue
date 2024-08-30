<template>
    <AppLayout title="Add Citation">
        <pegue-create
            :can="can"
        >
        </pegue-create>
    </AppLayout>
</template>
<script setup lang="ts">
import PegueCreate from "../Components/pegue/pegue-create.vue";
import {computed, defineComponent} from "vue";
import {usePage} from "@inertiajs/vue3";
import AppLayout from "../Layouts/AppLayout.vue";

const page = usePage();
const can = computed(() => page.props.can);

defineComponent({
    components: {
        PegueCreate
    }
})

</script>
