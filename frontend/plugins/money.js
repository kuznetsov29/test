const _amount = Symbol();
const _currency = Symbol();
const _decimal = Symbol();
const _newInstance = Symbol();
const _amountFilter = Symbol();
const _compare = Symbol();
const _conversionByCurrency = Symbol();

export default class Money {
    constructor(amount, currency = 'EN', decimal = 2) {
        this[_currency] = currency;
        this[_decimal] = decimal;
        this[_amount] = this[_amountFilter](amount);
    }

    get amount() {
        return this[_amount] / Math.pow(10, this[_decimal]);
    }

    get currency() {
        return this[_currency];
    }

    get amountRUB() {
        let amount = this[_conversionByCurrency]('RUB');

        return amount / Math.pow(10, this[_decimal]);
    }

    amountByCurrency(currency) {
        let amount = this[_conversionByCurrency](currency);

        return amount / Math.pow(10, this[_decimal]);
    }

    add(money) {
        if (money instanceof Money) {
            this[_amount] += money[_conversionByCurrency](this[_currency]);
        }

        return this;
    }

    subtract(money) {
        if (money instanceof Money) {
            this[_amount] -= money[_conversionByCurrency](this[_currency]);
        }

        return this;
    }

    set(money) {
        if (money instanceof Money) {
            this[_amount] = money[_conversionByCurrency](this[_currency]);
        }

        return this;
    }

    isEqual(money) {
        return this.compareMoney(money) === 0;
    }

    isBigger(money) {
        return this.compareMoney(money) > 0;
    }

    isSmaller(money) {
        return this.compareMoney(money) < 0;
    }

    compareMoney(money) {
        if (!(money instanceof Money)) {
            throw new Error('Value must be instance of Money');
        }

        let amount = money[_conversionByCurrency](this[_currency]);

        return this[_compare](amount);

    }

    [_compare](amount) {
        if (this[_amount] < amount) {
            return -1;
        } else if (this[_amount] > amount) {
            return 1;
        }

        return 0;
    }

    [_newInstance](amount) {
        return new Money(amount, this[_currency], this[_decimal]);
    }

    [_amountFilter](amount) {
        amount = parseFloat(amount) * Math.pow(10, this[_decimal]);

        return parseInt(amount);
    }

    [_conversionByCurrency](currency) {
        if (currency === this[_currency]) {
            return this[_amount];
        }

        switch (currency) {
            case 'RUB':
                return this[_amount] * 77;
            default:
                return NaN;
        }
    }
}