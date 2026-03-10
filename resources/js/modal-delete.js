import store from './redux/store';
import { setDeleteModal, setTable } from './redux/crud-slice';

const deleteModal = document.querySelector('.delete-modal');
const deleteModalBox = document.querySelector('.delete-modal__box');

store.subscribe(() => {
    const state = store.getState();
    const { active } = state.crud.deleteModal;
    deleteModal.classList.toggle('active', active);
    deleteModalBox.classList.toggle('active', active);
});

document.addEventListener('openModalDelete', event => {
    store.dispatch(setDeleteModal({
        active: true,
        endpoint: event.detail.endpoint
    }));
});

deleteModal?.addEventListener('click', event => {
    if (event.target.closest('.delete-modal__btn--cancel')) {
        store.dispatch(setDeleteModal({ active: false }));
        document.dispatchEvent(new CustomEvent('message', {
            detail: { message: 'Acción cancelada', type: 'error' }
        }));
    }
});

deleteModal?.addEventListener('click', async event => {
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