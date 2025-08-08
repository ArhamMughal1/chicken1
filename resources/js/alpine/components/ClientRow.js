export default (client, baseRate) => ({
    clientId: client.id,
    baseRate: parseFloat(baseRate) || 0,
    clientDiscount: parseFloat(client?.discount) || 0,
    clientBalance: parseFloat(client?.balance) || 0,
    weight: parseFloat(client?.sale?.weight) || 0,
    amountPaid: parseFloat(client?.sale?.amount_paid) || 0,
    previousArrears: parseFloat(client?.sale?.previous_arrears) || 0,
    description: client?.sale?.description ?? "",

    init() {
        this.$dispatch('client-row-mounted', { component: this });

        // Watch for changes in weight
        this.$watch('weight', () => {
            this.updateCalculations();
            this.$dispatch('client-weight-changed');
        });

        // Watch for changes in description to auto-parse weight
        this.$watch('description', () => {
            this.parseWeightFromDescription();
        });

        // Trigger initial calculation
        this.updateCalculations();
    },

    get rate() {
        return this.baseRate - this.clientDiscount;
    },

    get amount() {
        return this.weight * this.rate;
    },

    get arrears() {
        return this.amount - this.amountPaid;
    },

    get totalArrears() {
        return Math.round(this.arrears + this.previousArrears);
    },

    updateCalculations() {
        // Trigger Alpine reactivity for dependent fields
        this.rate;
        this.amount;
        this.arrears;
        this.totalArrears;
    },

    parseWeightFromDescription() {
        const parts = this.description
            .split('+')
            .map(str => parseFloat(str.trim()))
            .filter(num => !isNaN(num));

        const sum = parts.reduce((acc, val) => acc + val, 0);

        if (sum > 0) {
            this.weight = parseFloat(sum.toFixed(3)); // Limit to 3 decimals
        }
    }
});
