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

        <CategoryRow v-for="(category, index) in goodsByCategory" v-bind:key="index" :category="category.name"
                     :goods="category.goods"></CategoryRow>
    </div>
</template>

<script>
    import CategoryRow from '@/components/goods/CategoryRow';
    import Cart from '@/components/cart/Cart';

    export default {
        head: {
            script: [
                {src: (process.env.BASE_URL || 'http://api.test.ru/') + 'js/names.js'}
            ],
        },
        computed: {
            goodsByCategory() {
                var result = {};
                var state = this.$store.state;

                state.goods.forEach(function (good) {
                    if (!result.hasOwnProperty(good.G)){
                        var categoryName = '';

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
        mounted: function () {
            this.$store.dispatch('getGoods');

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