import Vuex from 'vuex';
import cart from './cart';
import {HTTP} from "./http-common";

const createStore = () => {
    return new Vuex.Store({
        modules: {
            cart,
        },
        state: {
            goods: [],
            dollarRate: 65,
            names: []
        },
        getters: {
            names(state) {
                return state.names;
            },
            goods(state) {
                return state.goods;
            }
        },
        mutations: {
            setNames(state, names) {
                state.names = names;
            },
            setGoods(state, goods) {
                state.goods = goods;
            }
        },
        actions: {
            async getNames(context) {
                const response = await HTTP.get('v1/name');
                context.commit('setNames', response.data);
            },
            async getGoods(context) {
                const response = await HTTP.get('v1/good');
                if (response.data.Success === true) {
                    context.commit('setGoods', response.data.Value.Goods);
                }
            }
        }
    })
};

export default createStore