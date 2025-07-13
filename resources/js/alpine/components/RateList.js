export default () => ({
    selectedMonth: new URLSearchParams(window.location.search).get('month') || new Date().toISOString().slice(0, 7),
});
