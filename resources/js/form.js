import store from './redux/store';
import { setForm, setTable } from './redux/crud-slice';
import { serializeUploadImages, initUploadImageListeners } from './upload-image';

const formContainer = document.querySelector('.crud-form');
let currentForm = null;

store.subscribe(() => {
    const state = store.getState();
    if (state.crud.form != currentForm) {
        formContainer.innerHTML = state.crud.form;
        currentForm = state.crud.form;
    }
});

initUploadImageListeners(formContainer);

formContainer?.addEventListener('click', async event => {
    event.preventDefault();

    if (event.target.closest('.save-button')) {
        const saveButton = event.target.closest('.save-button');
        const endpoint = saveButton.dataset.endpoint;
        const form = formContainer.querySelector('form');
        const formData = new FormData(form);

        if (formContainer.querySelector('.upload-image-container')) {
            const images = []
            const uploadImageContainers = formContainer.querySelectorAll('.upload-image-container')

            uploadImageContainers.forEach(uploadImageContainer => {
                if (uploadImageContainer.querySelector('img').getAttribute('src')) {
                    const image = {
                        name: uploadImageContainer.dataset.name,
                        languageAlias: uploadImageContainer.dataset.language,
                        imageConfigurations: JSON.parse(uploadImageContainer.dataset.configuration),
                        filename: uploadImageContainer.querySelector('img').getAttribute('src').split('/').pop(),
                        alt: uploadImageContainer.querySelector('img').getAttribute('alt'),
                        title: uploadImageContainer.querySelector('img').getAttribute('title')
                    }

                    images.push(image)
                }
            })

            formData.append('images', JSON.stringify(images))
        }

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            if (response.status === 500 || response.status === 422) {
                throw response;
            }

            if (response.status === 200) {
                const data = await response.json();
                store.dispatch(setForm(data.form));
                store.dispatch(setTable(data.table));
                document.dispatchEvent(new CustomEvent('message', {
                    detail: { message: data.message, type: 'success' }
                }));
            }

        } catch (error) {
            if (error.status === 422) {
                const data = await error.json();
                document.dispatchEvent(new CustomEvent('showformValidations', {
                    detail: {
                        formValidation: formContainer.querySelector('form').previousElementSibling,
                        errors: data.errors
                    }
                }));
                document.dispatchEvent(new CustomEvent('message', {
                    detail: { message: data.message, type: 'error' }
                }));
            }
            if (error.status === 500) {
                const data = await error.json();
                document.dispatchEvent(new CustomEvent('message', {
                    detail: { message: data.message, type: 'error' }
                }));
            }
        }
    }

    if (event.target.closest('.tab-language')) {
        const tab = event.target.closest('.tab-language');
        const target = tab.dataset.tab;
        formContainer.querySelectorAll('.tab-language').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        formContainer.querySelectorAll('.tab-content-language').forEach(c => c.classList.remove('active'));
        formContainer.querySelector(`.tab-content-language[data-tab="${target}"]`).classList.add('active');
    }

    if (event.target.closest('.tab')) {
        const tab = event.target.closest('.tab');
        const target = tab.dataset.tab;
        formContainer.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        formContainer.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        formContainer.querySelector(`.tab-content[data-tab="${target}"]`).classList.add('active');
    }
});