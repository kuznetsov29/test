<template>
    <span v-bind:class="{ 'text-red': rateDiff < 0, 'text-green': rateDiff > 0 }">
        {{money}} {{label()}}
    </span>
</template>

<script>
    export default {
        props: {
            moneyInCent: Number,
            fromCurrency: {
                type: String,
                default: "EN",
            },
            toCurrency: {
                type: String,
                default: "RUB",
            },
        },
        computed: {
            money() {
                return this.convert(this.moneyInCent)/ 100;
            },
            rateDiff() {
                if (this.moneyInCent === 0) {
                    return 0;
                }

                let rateDiff = this.oldRate - this.$store.state.dollarRate;
                this.oldRate = this.$store.state.dollarRate;

                return rateDiff;
            }
        },
        methods: {
            convert: function (value) {  // TODO реализовать настоящий конвертер from/to
                switch (this.fromCurrency) {
                    case "EN":
                        if (this.toCurrency === 'EN') {
                            return this.moneyInCent;
                        } else if (this.toCurrency === 'RUB') {
                            return Math.round(this.moneyInCent * this.$store.getters.dollarRateInCent / 100);
                        }
                    default:
                        return 0;

                }
            },
            label: function () {
                switch (this.toCurrency) {
                    case "EN":
                        return '$';
                    case "GE":
                        return '€';
                    case "RUB":
                        return '₽';
                    default:
                        return'';
                }
            }
        }
    }
</script>