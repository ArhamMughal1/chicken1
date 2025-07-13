export default () => ({
    selectedDate: new URLSearchParams(window.location.search).get('date') || new Date().toISOString().slice(0, 10),
});
