export default () => ({
    selectedDate: new URLSearchParams(window.location.search).get('date') || new Date().toISOString().slice(0, 10),
    selectedCategory: '',
    clients: [],
    filteredClients: [],
    purchaseWeight: 0,
    remainingWeight: 0,
    weightShortage: 0,
    cashSales: 0,
    creditSales: 0,
    totalSoldWeight: 0,

    init() {
        this.loadInitialData();
        this.$watch('selectedDate', () => this.updateUrl());

        window.addEventListener('client-row-mounted', (event) => {
            this.registerClientRow(event.detail.component)
        });
        window.addEventListener('client-weight-changed', (event) => {
            this.onClientWeightChanged()
        });
    },

    async loadInitialData() {
        try {
            const response = await fetch(`/api/sales/initial-data?date=${this.selectedDate}`);
            const data = await response.json();

            console.log(data);

            this.clients = data.clients.map(client => ({
                ...client,
                // Add Alpine.js magic properties for each client
                $component: null
            }));

            this.filteredClients = this.clients;
            this.purchaseWeight = data.purchaseWeight;
            this.weightShortage = data.weightShortage;
            this.remainingWeight = data.remainingWeight;
            this.cashSales = data.weightByCategory['cash'],
            this.creditSales = data.weightByCategory['credit']
        } catch (error) {
            console.error('Error loading initial data:', error);
        }
    },

    updateUrl() {
        if (this.selectedDate) {
            window.location.search = `?date=${this.selectedDate}`;
            this.loadInitialData();
        }
    },

    filterClients() {
        this.filteredClients = this.selectedCategory
            ? this.clients.filter(client => client.category === this.selectedCategory)
            : this.clients;
        this.calculateSales();
    },

    calculateSales() {
        this.cashSales = this.sumWeightByCategory('cash');
        this.creditSales = this.sumWeightByCategory('credit');
        this.totalSoldWeight = this.cashSales + this.creditSales;
        this.remainingWeight = parseFloat(this.purchaseWeight) - (parseFloat(this.weightShortage) + this.totalSoldWeight);
    },

    sumWeightByCategory(category) {
        return this.filteredClients
            .filter(client => client.category === category)
            .reduce((sum, client) => sum + (parseFloat(client.$component.weight) || 0), 0);
    },

    // Method to register client row components
    registerClientRow(component) {
        if (!this.clients.some(c => c.$component === component)) {
            const client = this.clients.find(c => c.id === component.clientId);
            if (client) {
                client.$component = component;
            }
        }
    },

    // Method to update sales when a client weight changes
    onClientWeightChanged() {
        this.calculateSales();
    },
});
