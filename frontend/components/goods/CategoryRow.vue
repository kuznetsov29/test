<template>
    <div class="w-5/6 max-w-lg ml-auto mr-auto mt-8 mb-8">
        <div class="bg-grey-lighter">
            <div class="flex flex-row">
                <div class="flex-1 text-grey-darker text-center bg-grey-light px-12 py-2 m-2">
                    {{category}}
                </div>
            </div>

            <Good  v-for="(good, index) in goods" v-bind:key="index" :good="good"></Good>
        </div>
    </div>
</template>

<script>
    import Good from "./Good";
    export default {
        components: {Good},
        props: {
            category: {
                type: String
            },
            goods: {
                type: Array
            }
        }
    }
</script>