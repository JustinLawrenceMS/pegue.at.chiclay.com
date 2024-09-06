<template>
    <div class="min-h-screen flex items-center justify-center">
        <div class="container">
            <div class="min-h-screen flex items-center justify-center">
                <div id="citation-card" class="row-auto">
                    <div class="col-auto flex flex-col">
                        <label for="citation" class="md:text-9xl text-6xl pb-10 dark:text-white">Add Citation</label>
                        <textarea
                            class="h-64 resize-none border
                            border-gray-700 rounded-md
                            focus:border-red-500
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
                            dark:bg-zinc-600 bg-slate-900 rounded
                            hover:bg-slate-500"
                            @click="handleClick">
                            Add
                        </button>
                        <div v-if="isLoading">
                            <img style="width: 3%; height: auto;" src="/storage/loader.gif" alt="loading..." />
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
    props: {
        can: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            citation: '',
            isLoading: false,
        };
    },
    methods: {
        async handleClick() {
            if (this.can.createCitations) {
                try {
                    this.isLoading = true;
                    axios.post(`/api/v1/citation`, {'citation': this.citation});
                    this.isLoading = false;
                } catch (e) {
                    console.log('error in post');
                    console.error(e);
                }
            } else {
                console.error("Error creating Citation");
            }
            this.citation = "";
        }
    },
}
</script>
<style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap');
    * {
        font-family: Raleway;
    }
</style>
