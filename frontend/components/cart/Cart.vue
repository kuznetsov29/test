<template>
    <div class="w-5/6 max-w-lg ml-auto mr-auto mt-8 mb-8">
        <div class="bg-grey-lighter">
            <div class="flex flex-row">
                <div class="flex-1 text-grey-darker text-center bg-grey-light px-12 py-2 m-2">
                    Корзина товаров
                </div>
            </div>

            <ItemCart v-for="itemCart in cartItems" v-bind:key="itemCart.good.T" :itemCart="itemCart"></ItemCart>
            <div class="flex flex-row">
                <div class="flex-1 text-grey-darker text-center bg-grey-light px-12 py-2 m-2">
                    Итого
                </div>
                <div class="flex-2 text-grey-lighter text-center bg-grey-dark px-12 py-2 m-2">
                    {{totalPrice}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ItemCart from "./ItemCart";

    export default {
        components: {ItemCart},
        computed: {
            cartItems() {
                return this.$store.state.cart.items
            },
            totalPrice() {
                var sum = 0;
                var self = this;
                this.$store.state.cart.items.forEach(function (itemCart) {
                    sum += itemCart.good.C * self.$store.state.dollarRate * itemCart.count;
                })
                return Math.round(sum * 100)/100;
            }
        },
        methods: {
        }
    }
</script>