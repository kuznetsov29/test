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
            <div class="bg-grey-light h-1 w-16 rounded"></div>
        </div>

        <CategoryRow v-for="category in goodsByCategory" v-bind:key="category.name" :category="category.name" :goods="category.goods"></CategoryRow>
    </div>
</template>

<script>
    import CategoryRow from '@/components/goods/CategoryRow';
    import Cart from '@/components/cart/Cart';

    export default {
        async asyncData({ store }) {
            await store.dispatch('getNames');
            await store.dispatch('getGoods');
        },
        computed: {
            goodsByCategory() {
                var result = {};
                var state = this.$store.state;

                state.goods.forEach(function (good) {
                    if (typeof result[good.G] === 'undefined') {
                        result[good.G] = {
                            name: state.names[good.G].G,
                            goods: []
                        };
                    }

                    good.name = state.names[good.G].B[good.T].N;

                    result[good.G].goods.push(good);
                });

                return result;
            }
        },
        methods: {
            getGoods: function () {
                this.$store.dispatch('getGoods');
            }
        },
        components: {
            CategoryRow,
            Cart
        },
        created: function () {
            var self = this;
            this.timer = setInterval(function () {
                self.getGoods();
                self.$store.state.dollarRate = Math.random() * (80 - 20) + 20;
            }, 15000);
        },
        beforeDestroy() {
            clearInterval(this.timer)
        }
    }
</script>