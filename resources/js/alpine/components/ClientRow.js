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
        // Register this component with the parent
        // this.$parent.registerClientRow(this);
        this.$dispatch('client-row-mounted', {component: this});

        // Watch for weight changes
        this.$watch('weight', () => {
            this.updateCalculations();
            this.$dispatch('client-weight-changed');
            // this.$parent.onClientWeightChanged();
        });
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

    // get previousArrears() {
    //     return this.clientBalance;
    // },

    get totalArrears() {
        return Math.round(this.arrears + this.previousArrears);
    },

    updateCalculations() {
        // Trigger getters to update
        this.rate;
        this.amount;
        this.arrears;
        this.totalArrears;
        this.description;
    }
});
