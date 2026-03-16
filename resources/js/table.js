import store from './redux/store';
import { setForm, setTable } from './redux/crud-slice';

const tableSection = document.querySelector('.crud-table');
let currentTable = null;

store.subscribe(() => {
    const state = store.getState();

    if (state.crud.table !== currentTable) {
        tableSection.innerHTML = state.crud.table || '';
        currentTable = state.crud.table;
    }
});

document.addEventListener('refreshTable', event => {
    tableSection.innerHTML = event.detail.table || '';
    currentTable = event.detail.table;
});

tableSection?.addEventListener('click', async (event) => {
    const editButton = event.target.closest('.edit-button');
    const deleteButton = event.target.closest('.delete-button');
    const paginationButton = event.target.closest('.table-pagination-page');

    try {
        if (editButton) {
            const endpoint = editButton.dataset.endpoint;
            const response = await fetch(endpoint, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();

            if (response.ok) {
                store.dispatch(setForm(data.form));
            } else {
                throw data;
            }
        }

        if (deleteButton) {
            const endpoint = deleteButton.dataset.endpoint;
            document.dispatchEvent(new CustomEvent('openModalDelete', { detail: { endpoint } }));
        }

        if (paginationButton && !paginationButton.classList.contains('inactive')) {
            const endpoint = paginationButton.dataset.pagination;
            const response = await fetch(endpoint, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();

            if (response.ok) {
                store.dispatch(setTable(data.table));

            } else {
                throw data;
            }
        }
    } catch (error) {
        const message = error?.message || 'Error de red o inesperado';
        document.dispatchEvent(new CustomEvent('message', { detail: { message, type: 'error' } }));
    }
});