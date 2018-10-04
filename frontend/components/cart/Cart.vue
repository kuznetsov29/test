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
                    <money :money-in-cent="totalPrice"></money>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ItemCart from "./ItemCart";
    import Money from "../Money";

    export default {
        components: {Money, ItemCart},
        computed: {
            cartItems() {
                return this.$store.state.cart.items
            },
            totalPrice() {
                let sum = 0;

                this.$store.state.cart.items.forEach((itemCart) => {
                    sum += itemCart.good.priceInCent * itemCart.count;
                });

                return sum;
            }
        },
        methods: {
        }
    }
</script>