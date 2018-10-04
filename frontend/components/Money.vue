<template>
    <span v-bind:class="{ 'text-red': rateDiff < 0, 'text-green': rateDiff > 0 }">
        {{money}} {{label()}}
    </span>
</template>

<script>
    export default {
        props: {
            moneyInCent: Number,
            toCurrency: {
                type: String,
                default: "",
            },
        },
        computed: {
            money() {
                return this.convert() / 100;
            },
            currency() {
                return this.toCurrency || this.$store.getters.currency; // Для установки валюты локально to-currency="RUB"
            },
            rateDiff() {
                if (this.moneyInCent === 0 || this.currency === 'EN') { // Не считем подсвечиваем нулевые цены и цены не зависящие от курса
                    return 0;
                }

                let rateDiff = this.oldRate - this.$store.state.dollarRate;
                this.oldRate = this.$store.state.dollarRate;

                return rateDiff;
            }
        },
        methods: {
            convert: function () { // Импровизированный корвертер валют
                switch (this.currency) {
                    case "RUB":
                        return Math.round(this.moneyInCent * this.$store.getters.dollarRateInCent / 100);
                    case "EN":
                        return this.moneyInCent;
                    default:
                        return 0;

                }
            },
            label: function () {
                switch (this.currency) {
                    case "EN":
                        return '$';
                    case "RUB":
                        return '₽';
                    default:
                        return'';
                }
            }
        }
    }
</script>