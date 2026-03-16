import store from './redux/store';
import { setForm, setTable } from './redux/crud-slice';

const formContainer = document.querySelector('.crud-form');
let currentForm = null;

store.subscribe(() => {
    const state = store.getState();
    if (state.crud.form != currentForm) {
        formContainer.innerHTML = state.crud.form;
        currentForm = state.crud.form;
    }
});

formContainer?.addEventListener('click', async (event) => {
    event.preventDefault();

    if (event.target.closest('.save-button')) {
        const form = formContainer.querySelector('form');
        const saveButton = event.target.closest('.save-button');
        const endpoint = saveButton.dataset.endpoint;
        const formData = new FormData(form);

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const data = await response.json();

            if (response.status === 422) {
                document.dispatchEvent(new CustomEvent('showformValidations', {
                    detail: {
                        formValidation: form.previousElementSibling,
                        errors: data.errors
                    }
                }));
                document.dispatchEvent(new CustomEvent('message', {
                    detail: { message: data.message, type: 'error' }
                }));
                return;
            }

            if (response.status === 500) {
                document.dispatchEvent(new CustomEvent('message', {
                    detail: { message: data.message, type: 'error' }
                }));
                return;
            }

            store.dispatch(setForm(data.form));
            store.dispatch(setTable(data.table));

            document.dispatchEvent(new CustomEvent('message', {
                detail: { message: data.message, type: 'success' }
            }));

        } catch (error) {
            console.error('Error en submit del form:', error);
            document.dispatchEvent(new CustomEvent('message', {
                detail: { message: 'Error de red o inesperado.', type: 'error' }
            }));
        }
    }

    if (event.target.closest('.tab-language')) {
        const tab = event.target.closest('.tab-language');
        const target = tab.dataset.tab

        formContainer.querySelectorAll('.tab-language').forEach(t => t.classList.remove('active'))
        tab.classList.add('active')

        formContainer.querySelectorAll('.tab-content-language').forEach(c => c.classList.remove('active'))
        formContainer.querySelector(`.tab-content-language[data-tab="${target}"]`).classList.add('active')
    }

    if (event.target.closest('.tab')) {
        const tab = event.target.closest('.tab');
        const target = tab.dataset.tab

        formContainer.querySelectorAll('.tab').forEach(t => t.classList.remove('active'))
        tab.classList.add('active')

        formContainer.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'))
        formContainer.querySelector(`.tab-content[data-tab="${target}"]`).classList.add('active')
    }
});
