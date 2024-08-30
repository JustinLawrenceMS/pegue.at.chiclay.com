<script setup>
    import {usePage} from "@inertiajs/vue3";
    import Cite from "citation-js";

    const page = usePage();
    const json = page.props.auth.user.jsonCitations;
    const citations = page.props.auth.user.citations;

    let bibs = [];
    let output = [];
    for (let i = 0; i < json.length; i++) {
        output[i] = new Cite(JSON.parse(json[i]));
        console.log(output[i]);
        bibs[i] = output[i].format('bibliography', {
            format: 'text',
            template: 'apa',
            lang: 'en-US'
        });
    }
</script>

<template>
    <a class="text-9xl no-underline" href="/pegue/create">+</a>

    <table>
        <thead>
            <th>
                Citation
            </th>
        </thead>
        <tbody>
            <tr v-for="(citation, index) in citations" :key="citation.id">
                <td class="p-11">
                    {{ bibs[index] }}
                </td>
                <td class="p-11">
                    {{ JSON.parse(citation.mesh_headings).join(", ") }}
                </td>
            </tr>
        </tbody>
    </table>
</template>
