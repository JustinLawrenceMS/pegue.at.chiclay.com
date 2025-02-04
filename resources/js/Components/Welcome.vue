<script setup>
import { router, usePage } from "@inertiajs/vue3";
import Cite from "citation-js";
import { ref, onMounted } from "vue";

const page = usePage();
const json = ref(page.props.auth.user?.jsonCitations ?? []);
const citations = ref(page.props.auth.user?.citations ?? []);

const bibs = ref([]);

onMounted(async () => {
    if (json.value.length) {
        try {
            bibs.value = json.value.map((entry) => {
                const cite = new Cite(JSON.parse(entry));
                return cite.format("bibliography", {
                    format: "text",
                    template: "apa",
                    lang: "en-US",
                });
            });
        } catch (error) {
            console.error("Error formatting citations:", error);
        }
    }
});
</script>

<template>
    <a class="text-9xl dark:text-white no-underline" href="/pegue/create">+</a>

    <table class="dark:text-white">
        <thead>
            <tr>
                <th>Citation</th>
                <th>Descriptors</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="citations.length === 0">
                <td colspan="2" class="p-11 text-center">No citations available.</td>
            </tr>
            <tr v-for="(citation, index) in citations" :key="citation.id">
                <td class="p-4">{{ bibs[index] }}</td>
                <td class="p-4">
                    {{
                        citation.mesh_headings
                            ? JSON.parse(citation.mesh_headings).join(", ")
                            : "No descriptors"
                    }}
                </td>
            </tr>
        </tbody>
    </table>
</template>
