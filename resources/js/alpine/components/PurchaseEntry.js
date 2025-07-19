export default (baseRate, loadWeight, netWeight) => ({
    selectedDate: new URLSearchParams(window.location.search).get('date') || document.getElementById('purchase_date')?.value || new Date().toISOString().slice(0, 10),
    selectedSupplier: new URLSearchParams(window.location.search).get('supplier') || document.getElementById('supplier_id')?.value || '',
    baseRate: parseFloat(baseRate) || 0,
    rateDifference: document.getElementById('rate_difference')?.value,
    loadWeight: loadWeight || 0,
    netWeight: netWeight || 0,
    shortWeight: 0,
    amount: 0,
    init() {
        this.updateCalculations();

        // Initialize values from URL or form elements
        this.syncFormWithState();

        // Set initial discount if supplier is already selected
        // if (this.selectedSupplier) {
        //     this.updateDiscount();
        // }

        // Set initial date if date is already selected
        if (this.selectedDate) {
            this.updateCalculations();
        }

        // Watch for supplier changes
        // this.$watch('selectedSupplier', () => {
        //     this.updateDiscount();
        //     this.updateUrl();
        // });

        // Watch for supplier changes
        this.$watch('selectedDate', () => {
            this.updateCalculations();
            this.updateUrl();
        });

        // Watch for changes in the select element (since we can't directly bind to select with x-model in this case)
        // if (this.$el.querySelector('#supplier_id')) {
        //     this.$el.querySelector('#supplier_id').addEventListener('change', (e) => {
        //         this.selectedSupplier = e.target.value;
        //         this.updateUrl();
        //     });
        // }

        // Watch for changes in the select element (since we can't directly bind to select with x-model in this case)
        if (this.$el.querySelector('#purchase_date')) {
            this.$el.querySelector('#purchase_date').addEventListener('change', (e) => {
                this.selectedDate = e.target.value;
                this.updateUrl();
            });
        }
    },

    syncFormWithState() {
        // Sync date input
        if (this.$el.querySelector('#purchase_date')) {
            this.$el.querySelector('#purchase_date').value = this.selectedDate;
        }

        // Sync supplier select
        if (this.$el.querySelector('#supplier_id')) {
            this.$el.querySelector('#supplier_id').value = this.selectedSupplier;
        }
    },

    updateDiscount() {
        const selectElement = this.$el.querySelector('#supplier_id');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        this.rateDifference = selectedOption ? parseFloat(selectedOption.dataset.discount) : 0;

        this.updateCalculations();
    },

    updateUrl($event) {
        const params = new URLSearchParams();

        // Add date if it has a value
        if (this.selectedDate) {
            params.set('date', this.selectedDate);
        }

        // Add supplier if it has a value
        // const supplierId = document.getElementById('supplier_id').value;
        // if (supplierId) {
        //     params.set('supplier', supplierId);
        // }

        // Update URL without page reload if you just want to update the query string
        // window.history.replaceState({}, '', `${window.location.pathname}?${params.toString()}`);

        // OR if you want to reload the page with new parameters:
        window.location.href = `${window.location.pathname}?${params.toString()}`;
        // $event.target.value && (window.location.href = `?date=${this.selectedDate}`);
    },
    updateCalculations() {
        // Calculate short weight
        this.shortWeight = parseFloat(this.loadWeight) - parseFloat(this.netWeight);

        this.rate = this.baseRate - (parseFloat(this.rateDifference) || 0);
        this.amount = ((this.netWeight * this.rate) % 1) >= 0.5 ? Math.ceil((this.netWeight * this.rate)) : Math.floor((this.netWeight * this.rate));
    }
});
