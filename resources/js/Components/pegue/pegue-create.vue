<template>
    <div class="min-h-screen flex items-center justify-center">
        <div class="container">
            <div class="min-h-screen flex items-center justify-center">
                <div id="citation-card" class="row-auto">
                    <div class="col-auto flex flex-col">
                        <label for="citation" class="text-3xl pb-2 dark:text-white">Add Citation</label>
                        <textarea
                            class="h-64 resize-none border
                            border-gray-200 rounded-md
                            focus:border-blue-500
                            focus:outline-none
                            focus:shadow-outline"
                            v-model="citation"
                            id="citation"
                            >
                        Enter a new citation
                        </textarea>
                    </div>
                    <div class="col-auto">
                        <button
                            class="px-4 py-2 pt-2 text-white
                            bg-blue-500 rounded
                            hover:bg-blue-700"
                            @click="handleClick">
                            Add
                        </button>
                        <div v-if="isLoading">
                            <img src="/storage/loader.gif" alt="loading..." />
                        </div>
                    </div>
                </div>
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
            isLoading: false,
        };
    },
    methods: {
        async handleClick() {
            this.citation = document.getElementById("citation").value;
            this.isLoading = true;
            await axios.post(`/api/v1/citation`, {'citation': this.citation});
            this.isLoading = false;
            this.citation = "";
        }
    },
}
</script>
