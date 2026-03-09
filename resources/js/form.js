import store from './redux/store';
import { setForm, setTable } from './redux/crud-slice';

const formContainer = document.querySelector('.admin-form');
let currentForm = null;

store.subscribe(() => {
    const state = store.getState();
    if (state.crud.form !== currentForm) {
        formContainer.innerHTML = state.crud.form || '';
        currentForm = state.crud.form;

        attachFormSubmit();
    }
});

function attachFormSubmit () {
    const form = formContainer.querySelector('form');
    if (!form) return;

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const saveButton = form.querySelector('.save-button');
        if (!saveButton) return;

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

            document.dispatchEvent(new CustomEvent('refreshTable', {
                detail: { table: data.table }
            }));

            document.dispatchEvent(new CustomEvent('message', {
                detail: { message: data.message, type: 'success' }
            }));

        } catch (error) {
            console.error('Error en submit del form:', error);
            document.dispatchEvent(new CustomEvent('message', {
                detail: { message: 'Error de red o inesperado.', type: 'error' }
            }));
        }
    });
}

document.addEventListener('refreshForm', event => {
    formContainer.innerHTML = event.detail.form || '';
    attachFormSubmit();
});

formContainer?.addEventListener('input', (event) => {
    if (event.target.type === 'range') {
        const rangeValue = event.target.parentElement.querySelector('.range-value');
        if (rangeValue) rangeValue.innerText = event.target.value;
    }
});