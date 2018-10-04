<template>
    <div>
        <section class="bg-white py-8">
            <div class="w-5/6 max-w-lg ml-auto mr-auto mt-8 mb-8">
                <div class="flex flex-col md:flex-row items-center justify-center">
                    <p class="text-xl leading-normal mr-6 mb-3 md:mb-0 text-center md:text-left"> JS part</p>
                </div>
            </div>
        </section>

        <Cart></Cart>

        <div class="flex justify-center">
            <div class="relative">
                <select @input="setCurrency"
                        class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker
                    py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey"
                        id="grid-state">
                    <option v-for="currency in currencyList" v-bind:value="currency.value">{{ currency.text }}</option>
                </select>
                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
        </div>

        <CategoryRow v-for="(category, index) in goodsByCategory" v-bind:key="index" :category="category.name"
                     :goods="category.goods"></CategoryRow>
    </div>
</template>

<script>
    import CategoryRow from '@/components/goods/CategoryRow';
    import Cart from '@/components/cart/Cart';

    export default {
        computed: {
            currencyList() {
                return this.$store.getters.currencyList;
            },
            goodsByCategory() {
                const result = {};

                this.$store.getters.goods.forEach(function (good) {
                    if (!result.hasOwnProperty(good.G)) {
                        let categoryName = '';

                        if (typeof store !== 'undefined') {
                            categoryName = store[good.G].G;
                        }

                        result[good.G] = {
                            name: categoryName,
                            goods: []
                        };
                    }

                    if (typeof store !== 'undefined') {
                        good.name = store[good.G].B[good.T].N;
                    }

                    result[good.G].goods.push(good);
                });

                return result;
            }
        },
        components: {
            CategoryRow,
            Cart
        },
        methods: {
            setCurrency(e) {
                this.$store.commit('setCurrency', e.target.value);
            },
        },
        mounted: function () {
            const script = document.createElement('script');

            script.onload = () => {
                this.$store.dispatch('getGoods');
            };

            script.src = (process.env.BASE_URL || 'http://api.test.ru/') + 'js/names.js';

            document.head.appendChild(script);

            this.timer = setInterval(() => {
                this.$store.dispatch('getGoods');
                this.$store.commit('changeDollarRate');
            }, 15000);
        },
        beforeDestroy() {
            clearInterval(this.timer)
        }
    }
</script>