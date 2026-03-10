// modal-delete.js
import store from './redux/store';
import { setDeleteModal, setTable } from './redux/crud-slice';

const deleteModalBox = document.querySelector('.delete-modal'); // ← renombrado

store.subscribe(() => {
    const { deleteModal } = store.getState().crud;
    deleteModalBox?.classList.toggle('active', deleteModal.active);
});

document.addEventListener('openModalDelete', event => {
    store.dispatch(setDeleteModal({
        active: true,
        endpoint: event.detail.endpoint
    }));
});

deleteModalBox?.addEventListener('click', event => {
    if (event.target.closest('.delete-modal__btn--cancel')) {
        store.dispatch(setDeleteModal({ active: false }));
        document.dispatchEvent(new CustomEvent('message', {
            detail: { message: 'Acción cancelada', type: 'error' }
        }));
        return;
    }
});

deleteModalBox?.addEventListener('click', async event => {
    if (!event.target.closest('.delete-modal__btn--confirm')) return;

    const endpoint = store.getState().crud.deleteModal.endpoint;
    store.dispatch(setDeleteModal({ active: false }));

    try {
        const response = await fetch(endpoint, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const data = await response.json();

        store.dispatch(setTable(data.table));

        document.dispatchEvent(new CustomEvent('message', {
            detail: { message: data.message, type: 'success' }
        }));
    } catch (error) {
        document.dispatchEvent(new CustomEvent('message', {
            detail: { message: error.message, type: 'error' }
        }));
        console.log('Error al eliminar:', endpoint, error);
    }
});