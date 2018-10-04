import _ from 'lodash';

export default {
    namespaced: true,
    state: {
        items: []
    },
    getters: {
        cart(state) {
            return state.items;
        }
    },
    mutations: {
        updateCount(state, data) {
            var itemIndex = _.findIndex(state.items, function(item) { return item.good.T === data.good.T; });

            state.items[itemIndex].count = data.count;
        },
        addToCart(state, good) {
            var itemIndex = _.findIndex(state.items, function(item) { return item.good.T === good.T; });

            if (itemIndex !== -1) {
                if (state.items[itemIndex].count >= good.P) {
                    alert('Нельзя добавить больше ' + good.P);
                    return false;
                }

                state.items[itemIndex].count++;
                return false;
            }

            state.items.push({
                good: good,
                count: 1
            });
        },
        removeFromCart(state, good) {
            for (var i = 0; i < state.items.length; i++) {
                if (state.items[i].good.T === good.T) {
                    state.items.splice(i, 1);
                }
            }
        }
    },
    actions: {
        addToCart(state, good) {
            state.commit('addToCart', good);
        }
    }
};