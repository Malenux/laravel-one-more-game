document.addEventListener('showForm', function (event) {
    loadFormData(event.detail.data);
});

const formContainer = document.querySelector('.form');

document.addEventListener('keydown', function (event) {
    if (event.key === 'Enter' && event.target.tagName === 'INPUT') {
        event.preventDefault();
    }
});

formContainer.addEventListener('click', async function (event) {
    event.preventDefault();

    if (event.target.closest('.save-icon')) {
        const form = document.querySelector('.form form');
        const formData = new FormData(form);
        const formDataJson = {};

        for (const [key, value] of formData.entries()) {
            formDataJson[key] = value !== '' ? value : null;
        }

        const id = document.querySelector('[name="id"]').value;
        const panel = document.querySelector('.admin-panel');

        let endpoint;
        if (id) {
            endpoint = panel.dataset.updateUrl.replace('__ID__', id);
            formDataJson._method = 'PUT';
        } else {
            endpoint = panel.dataset.storeUrl;
        }

        delete formDataJson.id;

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formDataJson)
            });

            if (!response.ok) {
                throw response;
            }

            const data = await response.json();

            document.dispatchEvent(new CustomEvent('notice', {
                detail: {
                    message: 'Usuario guardado correctamente',
                    type: 'success'
                }
            }));

            resetForm();
            window.location.reload();

        } catch (error) {
            if (error.status === 422) {
                const data = await error.json();
                showValidationErrors(data.errors);

                document.dispatchEvent(new CustomEvent('notice', {
                    detail: {
                        message: 'Hay errores de validación',
                        type: 'error'
                    }
                }));
            } else {
                document.dispatchEvent(new CustomEvent('notice', {
                    detail: {
                        message: 'No se han podido guardar los datos',
                        type: 'error'
                    }
                }));
            }
        }
    }

    if (event.target.closest('.clean-icon')) {
        resetForm();
    }

    if (event.target.closest('.tab')) {
        const clickedTab = event.target.closest('.tab');

        document.querySelector('.tab.active')?.classList.remove('active');
        clickedTab.classList.add('active');

        document.querySelector('.tab-content.active')?.classList.remove('active');
        document.querySelector(`.tab-content[data-tab='${clickedTab.dataset.tab}']`)?.classList.add('active');
    }

    if (event.target.closest('.close-validation-errors')) {
        clearValidationErrors();
    }
});

function showValidationErrors (errors) {
    clearValidationErrors();

    const errorsContainer = document.querySelector('.validation-errors');
    const errorsList = document.querySelector('.validation-errors ul');
    errorsList.innerHTML = '';

    Object.entries(errors).forEach(([field, messages]) => {
        const errorMessage = document.createElement('li');
        errorMessage.textContent = Array.isArray(messages) ? messages[0] : messages;
        errorsList.appendChild(errorMessage);

        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('error');
        }
    });

    errorsContainer.classList.add('active');
}

function clearValidationErrors () {
    const errorsContainer = document.querySelector('.validation-errors');
    const errorsList = document.querySelector('.validation-errors ul');

    errorsList.innerHTML = '';
    errorsContainer?.classList.remove('active');

    document.querySelectorAll('.form-element-input input.error').forEach(input => {
        input.classList.remove('error');
    });
}

function loadFormData (data) {
    const form = document.querySelector('.form form');
    form.reset();
    clearValidationErrors();

    Object.entries(data).forEach(([key, value]) => {
        const input = document.querySelector(`[name="${key}"]`);
        if (input && input.type !== 'file') {
            input.value = value || '';
        }
    });
}

function resetForm () {
    const form = document.querySelector('.form form');
    form.reset();
    document.querySelector('[name="id"]').value = '';
    clearValidationErrors();
}
