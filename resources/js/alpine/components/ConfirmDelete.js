export default (formAction) => ({
    isOpen: false,
    formAction: formAction,

    init() {
        // Component initialization if needed
    },

    confirmedDelete() {
        this.isOpen = true;
    },

    submitForm() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = this.formAction;

        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        // Add method spoofing for DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    }
});
