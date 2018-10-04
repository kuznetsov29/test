import Vuex from 'vuex';
import cart from './cart';
import {HTTP} from "../plugins/http-common";

const createStore = () => {
    return new Vuex.Store({
        strict: process.env.NODE_ENV !== 'production',
        modules: {
            cart,
        },
        state: {
            goods: [],
            dollarRate: 65,
            currency: 'RUB',
            currencyList: [
                { text: 'Рубли', value: 'RUB' },
                { text: 'Доллары', value: 'EN' },
            ],
        },
        getters: {
            dollarRateInCent(state) {
                return parseInt(state.dollarRate * 100);
            },
            currency(state) {
                return state.currency;
            },
            currencyList(state) {
                return state.currencyList;
            },
            goods(state) {
                return state.goods;
            }
        },
        mutations: {
            setCurrency(state, currency) {
                state.currency = currency;
            },
            setGoods(state, goods) {
                state.goods = [];

                goods.forEach(function (good) {
                    good.priceInCent = parseInt(good.C * 100);
                    state.goods.push(good);
                });
            },
            changeDollarRate(state) {
                state.dollarRate = Math.random() * (80 - 20) + 20;
            }
        },
        actions: {
            async getGoods(context) {
                const response = await HTTP.get('js/data.json');
                if (response.data.Success === true) {
                    context.commit('setGoods', response.data.Value.Goods);
                }
            }
        }
    })
};

export default createStore