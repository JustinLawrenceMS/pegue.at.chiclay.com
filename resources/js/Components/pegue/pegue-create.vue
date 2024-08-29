<template>
    <div class="container">
        <h1>Add Citation</h1>
        <div class="row-auto">
            <div class="col-auto">
                <textarea
                    v-model="citation"
                    id="citation"
                    >
                Enter a new citation
                </textarea>
            </div>
            <div class="col-auto">
                <button
                    class="btn btn-primary"
                    @click="handleClick">
                    Add
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "PegueCreate",
    data() {
        return {
            citation: '',
        };
    },
    methods: {
        async handleClick() {
            this.citation = document.getElementById("citation").value;
            await axios.post(`/api/v1/citation`, {'citation': this.citation});
        }
    },
}
</script>
