let activeUploadContainer = null;
const modalImage = document.querySelector('#modal-image');

document.addEventListener('openModalImage', event => {

    modalImage?.classList.add('active');
    activeUploadContainer = event.detail.uploadImageContainer;

    const currentSrc = activeUploadContainer.querySelector('img')?.getAttribute('src');
    const filename = currentSrc?.split('/').pop();

    if (filename) {
        modalImage.querySelector(`.image-modal__item[data-filename="${filename}"]`)?.classList.add('selected');
        modalImage.querySelector('.image-modal__btn--confirm')?.classList.add('active');
        modalImage.querySelector('input[name="alt"]').value = activeUploadContainer.querySelector('img').getAttribute('alt') ?? '';
        modalImage.querySelector('input[name="title"]').value = activeUploadContainer.querySelector('img').getAttribute('title') ?? '';
    }
});

modalImage?.addEventListener('click', async event => {

    if (event.target.closest('.image-modal__close')) {
        modalImage.classList.remove('active');
        modalImage.querySelector('.image-modal__item.selected')?.classList.remove('selected');
        modalImage.querySelector('.image-modal__btn--confirm')?.classList.remove('active');
        modalImage.querySelector('input[name="alt"]').value = '';
        modalImage.querySelector('input[name="title"]').value = '';
        activeUploadContainer = null;
    }

    if (event.target.closest('.image-modal__item')) {
        modalImage.querySelector('.image-modal__item.selected')?.classList.remove('selected');
        event.target.closest('.image-modal__item').classList.add('selected');
        modalImage.querySelector('.image-modal__btn--confirm')?.classList.add('active');
    }

    if (event.target.closest('.image-modal__btn--confirm')) {
        const selectedItem = modalImage.querySelector('.image-modal__item.selected');
        if (!selectedItem || !activeUploadContainer) return;

        if (activeUploadContainer.dataset.quantity === 'single') {
            const img = activeUploadContainer.querySelector('img');
            img.src = selectedItem.querySelector('img').getAttribute('src');
            img.alt = modalImage.querySelector('input[name="alt"]').value;
            img.title = modalImage.querySelector('input[name="title"]').value;
            activeUploadContainer.querySelector('.upload-image').classList.remove('hidden');
        } else {
            const clone = activeUploadContainer.querySelector('.upload-image').cloneNode(true);
            clone.querySelector('img').src = selectedItem.querySelector('img').getAttribute('src');
            clone.querySelector('img').alt = modalImage.querySelector('input[name="alt"]').value;
            clone.querySelector('img').title = modalImage.querySelector('input[name="title"]').value;
            activeUploadContainer.appendChild(clone);
            clone.classList.remove('hidden');
        }

        modalImage.querySelector('input[name="alt"]').value = '';
        modalImage.querySelector('input[name="title"]').value = '';
        modalImage.classList.remove('active');
    }

    if (event.target.closest('.image-modal__item-delete')) {
        const endpoint = event.target.closest('.image-modal__item-delete').dataset.endpoint;

        const result = await fetch(endpoint, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await result.json();
        modalImage.innerHTML = data.imageGallery;
    }
});

modalImage?.addEventListener('change', async event => {
    if (event.target.closest('.image-modal__upload-input')) {
        try {
            const input = event.target.closest('.image-modal__upload-input');
            const endpoint = input.dataset.endpoint;
            const formData = new FormData();
            formData.append('image', input.files[0]);

            const result = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const data = await result.json();
            modalImage.innerHTML = data.imageGallery;

        } catch (error) {
            console.error(error);
        }
    }
});