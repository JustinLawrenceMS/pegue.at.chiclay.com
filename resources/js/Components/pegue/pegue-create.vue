<template>
    <div class="min-h-screen flex items-center justify-center">
        <div class="container">
            <div class="min-h-screen flex items-center justify-center">
                <div
                    id="citation-card"
                    class="row-auto bg-gray-100 p-5 rounded-3xl dark:bg-gray-800"
                >
                    <div class="col-auto flex flex-col">
                        <label
                            for="citation"
                            class="md:text-6xl text-4xl pb-5 dark:text-white"
                        >
                            Add Citation
                        </label>
                        <textarea
                            class="h-64 resize-none border border-gray-700 rounded-md focus:border-red-500 focus:outline-none focus:shadow-outline p-2"
                            v-model="citation"
                            id="citation"
                            placeholder="Enter a new citation"
                        ></textarea>
                    </div>

                    <div class="col-auto mt-4">
                        <button
                            class="px-4 py-2 text-white dark:bg-zinc-600 bg-slate-900 rounded hover:bg-slate-500"
                            @click="handleClick"
                            :disabled="isLoading"
                        >
                            {{ isLoading ? "Adding..." : "Add" }}
                        </button>
                        <div v-if="isLoading" class="mt-2">
                            <img
                                class="w-8 h-8"
                                src="/storage/loader.gif"
                                alt="loading..."
                            />
                        </div>
                        <p v-if="errorMessage" class="text-red-500 mt-2">
                            {{ errorMessage }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

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
            citation: "",
            isLoading: false,
            errorMessage: "",
        };
    },
    methods: {
        async handleClick() {
            if (!this.can.createCitations) {
                this.errorMessage = "Error: You do not have permission to create citations.";
                return;
            }

            if (!this.citation.trim()) {
                this.errorMessage = "Citation cannot be empty.";
                return;
            }

            this.isLoading = true;
            this.errorMessage = "";

            try {
                await axios.post(`/api/v1/citation`, { citation: this.citation });
                this.$inertia.visit("/dashboard"); // Use Inertia.js for SPA experience
            } catch (e) {
                console.error("Error posting citation:", e);
                this.errorMessage = "Failed to add citation. Please try again.";
            } finally {
                this.isLoading = false;
                this.citation = "";
            }
        },
    },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap");

* {
    font-family: Raleway, sans-serif;
}
</style>
