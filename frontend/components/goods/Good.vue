<template>
    <div class="flex flex-row">
        <div class="flex-1 bg-white px-8 py-2 m-2 mt-0">
            {{good.name}}({{good.P}})
        </div>
        <div class="flex-2 text-grey-darker text-center bg-grey-light px-4 py-2 m-2 mt-0">
            <Money :money-in-cent="good.priceInCent"></Money>
        </div>
        <div v-on:click="addToCart(good)" class="flex-2 text-grey-darker text-center bg-grey-light px-4 py-2 m-2 mt-0">
            add
        </div>
    </div>
</template>

<script>
    import Money from "../Money";
    export default {
        components: {Money},
        props: {
            good: {
                type: Object
            }
        },
        methods: {
            addToCart(good) {
                this.$store.dispatch('cart/addToCart', good)
            }
        }
    }
</script>