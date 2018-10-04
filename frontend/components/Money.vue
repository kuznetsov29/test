<template>
    <span v-bind:class="{ 'text-red': rateDiff < 0, 'text-green': rateDiff > 0 }">
        {{money}}
    </span>
</template>

<script>
    export default {
        props: {
            moneyInCent: Number,
        },
        computed: {
            money() {
                return Math.round(this.moneyInCent * this.$store.getters.dollarRateInCent / 100)/ 100
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
        }
    }
</script>