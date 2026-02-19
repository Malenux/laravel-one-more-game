const tableContainer = document.querySelector('.admin-table');

let filterQuery = '';

tableContainer.addEventListener('click', async function (event) {

    if (event.target.closest('.edit-button')) {
        const button = event.target.closest('.edit-button');
        const id = button.dataset.id;
        const panel = document.querySelector('.admin-panel');
        const endpoint = panel.dataset.editUrl.replace('__ID__', id);

        try {
            const response = await fetch(endpoint, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            });

            if (!response.ok) throw response;

            const data = await response.json();

            document.dispatchEvent(new CustomEvent('showForm', {
                detail: { data }
            }));

        } catch (error) {
            document.dispatchEvent(new CustomEvent('notice', {
                detail: { message: 'No se han podido recuperar el dato', type: 'error' }
            }));
        }
    }

    if (event.target.closest('.delete-button')) {
        const button = event.target.closest('.delete-button');
        const id = button.dataset.id;
        const panel = document.querySelector('.admin-panel');

        document.dispatchEvent(new CustomEvent('showDeleteModal', {
            detail: {
                deleteUrl: panel.dataset.deleteUrl.replace('__ID__', id)
            }
        }));
    }

    if (event.target.closest('.pagination-button') && !event.target.closest('.pagination-button').disabled) {
        const button = event.target.closest('.pagination-button');
        const page = button.dataset.page;
        const panel = document.querySelector('.admin-panel');

        let url = `${panel.dataset.indexUrl}?page=${page}`;
        if (filterQuery) url += `&${filterQuery}`;

        loadPage(url);
    }

    if (event.target.closest('.filter-button')) {
        document.dispatchEvent(new CustomEvent('showFilterModal'));
    }
});

async function loadPage (url) {
    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        });

        if (!response.ok) throw response;

        const data = await response.json();

        document.querySelector('#table-wrapper').innerHTML = data.table;

    } catch (error) {
        document.dispatchEvent(new CustomEvent('notice', {
            detail: { message: 'No se pudo cargar la página', type: 'error' }
        }));
    }
}

document.addEventListener('filterApplied', function (event) {
    filterQuery = event.detail.query;
    const panel = document.querySelector('.admin-panel');
    loadPage(`${panel.dataset.indexUrl}?${filterQuery}`);
});

document.addEventListener('filterCleared', function () {
    filterQuery = '';
    const panel = document.querySelector('.admin-panel');
    loadPage(panel.dataset.indexUrl);
});

document.addEventListener('recordSaved', function (event) {
    if (event.detail?.table) {
        document.querySelector('#table-wrapper').innerHTML = event.detail.table;
    }
});

document.addEventListener('recordDeleted', function (event) {
    if (event.detail?.table) {
        document.querySelector('#table-wrapper').innerHTML = event.detail.table;
    }
});