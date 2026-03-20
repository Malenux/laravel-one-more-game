export function serializeUploadImages (container) {
    const images = [];
    const containers = container.querySelectorAll('.upload-image-container');

    containers.forEach(uploadContainer => {
        const img = uploadContainer.querySelector('img');
        const src = img?.getAttribute('src');
        if (src) {
            images.push({
                name: uploadContainer.dataset.name,
                languageAlias: uploadContainer.dataset.language,
                imageConfigurations: JSON.parse(uploadContainer.dataset.configuration || '{}'),
                filename: src.split('/').pop(),
                alt: img.getAttribute('alt') ?? '',
                title: img.getAttribute('title') ?? '',
            });
        }
    });

    return images;
}

export function initUploadImageListeners (container) {
    container.addEventListener('click', event => {

        if (event.target.closest('.square-button')) {
            const uploadImageContainer = event.target.closest('.upload-image-container');
            document.dispatchEvent(new CustomEvent('openModalImage', {
                detail: { uploadImageContainer }
            }));
        }

        if (event.target.closest('.upload-image-container .delete-button')) {
            const uploadImage = event.target.closest('.upload-image');
            const img = uploadImage.querySelector('img');
            img.src = '';
            img.alt = '';
            img.title = '';
            uploadImage.classList.add('hidden');
        }
    });
}