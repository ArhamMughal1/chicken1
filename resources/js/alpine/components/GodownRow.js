export default (rate)=> ({
    rateDifference: 0,
    rate: parseFloat(rate) || 0,
    weight: 0,
    amount: 0,
    amountPaid: 0,
    arrears: 0,
    previousArrears: 0,
    totalArrears: 0,

    init(){
        this.$parent.registerGodownRow(this);
    },

    updateCalculations() {
        this.amount = (this.rate * this.weight).toFixed(2);
        this.arrears = this.amount - this.amountPaid;
        this.totalArrears = parseFloat(this.previousArrears) + parseFloat(this.arrears);
    }
})
