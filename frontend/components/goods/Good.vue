<template>
    <div class="flex flex-row">
        <div class="flex-1 bg-white px-8 py-2 m-2 mt-0">
            {{good.name}}({{good.P}})
        </div>
        <div v-bind:class="{ 'bg-red': priceDiff < 0, 'bg-green': priceDiff > 0 }" class="flex-2 text-grey-darker text-center bg-grey-light px-4 py-2 m-2 mt-0">
            {{price}}
        </div>
        <div v-on:click="addToCart(good)" class="flex-2 text-grey-darker text-center bg-grey-light px-4 py-2 m-2 mt-0">
            add
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            good: {
                type: Object
            }
        },
        computed: {
            priceDiff() {
                var oldPrice = this.oldPrice;
                this.oldPrice = this.$store.state.dollarRate;

                return oldPrice - this.$store.state.dollarRate;
            },
            price() {
                return Math.round(this.good.C * this.$store.state.dollarRate * 100)/100;
            }
        },
        methods: {
            addToCart(good) {
                this.$store.dispatch('cart/addToCart', good)
            }
        },
        created: function () {
            this.oldPrice = this.$store.state.dollarRate;
        }
    }
</script>