export default (baseRate, initialRateDifference, initialRate, initialWeight, initialAmount, initialAmountPaid, initialArrears, initialPreviousArrears, initialTotalArrears) => ({
    baseRate: parseFloat(baseRate) || 0,
    rateDifference: parseFloat(initialRateDifference) || 0,
    rate: parseFloat(initialRate) || 0,
    weight: parseFloat(initialWeight) || 0,
    amount: parseFloat(initialAmount) || 0,
    amountPaid: parseFloat(initialAmountPaid) || 0,
    arrears: parseFloat(initialArrears) || 0,
    previousArrears: parseFloat(initialPreviousArrears) || 0,
    totalArrears: parseFloat(initialTotalArrears) || 0,

    init() {
        this.updateCalculations();
    },

    updateCalculations() {
        // Update rate
        this.rate = this.baseRate - (parseFloat(this.rateDifference) || 0);

        // Update amount
        this.amount = (parseFloat(this.rate) || 0) * (parseFloat(this.weight) || 0);

        // Update arrears
        this.arrears = (parseFloat(this.amount) || 0) - (parseFloat(this.amountPaid) || 0);

        // Update total arrears
        this.totalArrears = Math.round((parseFloat(this.arrears) || 0) + (parseFloat(this.previousArrears) || 0));
    }
});
