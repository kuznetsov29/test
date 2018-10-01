<template>
    <div class="flex flex-row">
        <div class="flex-1 bg-white px-8 py-2 m-2 mt-0">
            {{itemCart.good.name}}
        </div>
        <div class="flex-2 text-grey-darker text-center bg-grey-light px-4 py-2 m-2 mt-0">

            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                   type="number" v-model.number="itemCart.count" min="0" v-bind:max="itemCart.good.P"
                   v-on:change="checkForm">

            <p v-if="errors.length" class="text-red">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </p>

        </div>
        <div class="flex-2 text-grey-darker text-center bg-grey-light px-4 py-2 m-2 mt-0">
            {{price}}
        </div>
        <div v-on:click="removeFromCart(itemCart.good)"
             class="flex-2 text-grey-darker text-center bg-grey-light px-4 py-2 m-2 mt-0">
            remove
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                errors: []
            };
        },
        props: {
            itemCart: {
                type: Object
            }
        },
        computed: {
            price() {
                return Math.round(this.itemCart.good.C * this.$store.state.dollarRate * this.itemCart.count * 100)/100;
            }
        },
        methods: {
            removeFromCart(good) {
                this.$store.commit('cart/removeFromCart', good);
            },
            checkForm: function (e) {
                this.errors = [];

                if (this.itemCart.count === 0) {
                    this.removeFromCart(this.itemCart.good);
                }

                if (this.itemCart.count <= this.itemCart.good.P) {
                    return true;
                }

                this.errors.push('Нельзя добавить больше ' + this.itemCart.good.P);

                e.preventDefault();
            }
        }
    }
</script>