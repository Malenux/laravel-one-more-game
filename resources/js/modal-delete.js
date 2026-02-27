export default (() => {

    const deleteModal = document.querySelector('.delete-modal');
    const deleteModalBox = document.querySelector('.delete-modal__box');

    let deleteUrl = null;

    document.addEventListener('openModalDelete', event => {

        deleteUrl = event.detail.endpoint;

        deleteModal.classList.add('active');
        deleteModalBox.classList.add('active');

    });

    deleteModal?.addEventListener('click', async event => {

        if (event.target.closest('.delete-modal__btn--cancel')) {

            deleteModal.classList.remove('active');
            deleteModalBox.classList.remove('active');

            document.dispatchEvent(new CustomEvent('openMessage', {
                detail: {
                    message: 'Acción cancelada',
                    type: 'error'
                }
            }));
        }

        if (event.target.closest('.delete-modal__btn--confirm')) {

            deleteModal.classList.remove('active');
            deleteModalBox.classList.remove('active');

            try {

                const response = await fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                document.dispatchEvent(new CustomEvent('openMessage', {
                    detail: {
                        message: data.message,
                        type: 'success'
                    }
                }));

                document.dispatchEvent(new CustomEvent('refreshTable', {
                    detail: {
                        table: data.table,
                    }
                }));

            } catch (error) {

                document.dispatchEvent(new CustomEvent('openMessage', {
                    detail: {
                        message: 'Ocurrió un error inesperado',
                        type: 'error'
                    }
                }));

                console.log('Erros al eliminar el dato', deleteUrl, error);

            }
        }

    });

})();