import store from './redux/store';
import { setFilterModal, setTable } from './redux/crud-slice';

const filterOverlay = document.querySelector('#modal-filter');
const filterModalBox = document.querySelector('#modal-filter .filter-modal');

store.subscribe(() => {
    const { filterModal } = store.getState().crud;

    filterOverlay?.classList.toggle('active', filterModal.active);
    filterModalBox?.classList.toggle('active', filterModal.active);

    const filterButton = document.querySelector('.filter-button');
    filterButton?.classList.toggle('active', Object.keys(filterModal.params).length > 0);

});

document.addEventListener('click', event => {
    const filterButton = event.target.closest('.filter-button');
    if (filterButton) {
        store.dispatch(setFilterModal({
            active: true,
            endpoint: filterButton.dataset.endpoint
        }));
    }
});

filterModalBox?.addEventListener('click', async event => {

    if (event.target.closest('.filter-modal__btn--cancel')) {
        store.dispatch(setFilterModal({ active: false }));
        return;
    }

    if (!event.target.closest('.filter-modal__btn--confirm')) return;

    const inputs = filterModalBox.querySelectorAll('[data-filter]');
    const params = {};
    inputs.forEach(input => {
        if (input.value.trim() !== '') params[input.name] = input.value.trim();
    });

    const endpoint = store.getState().crud.filterModal.endpoint;
    store.dispatch(setFilterModal({ active: false, params }));

    try {
        const query = new URLSearchParams(params).toString();
        const url = query ? `${endpoint}?${query}` : endpoint;

        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const data = await response.json();

        store.dispatch(setTable(data.table));

        document.dispatchEvent(new CustomEvent('message', {
            detail: { message: data.message ?? 'Filtros aplicados', type: 'success' }
        }));
    } catch (error) {
        document.dispatchEvent(new CustomEvent('message', {
            detail: { message: error.message, type: 'error' }
        }));
        console.error('Error al filtrar:', error);
    }
});