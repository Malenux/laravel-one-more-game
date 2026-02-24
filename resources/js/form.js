const endpoint = '/admin/users'

document.addEventListener('click', async (event) => {

    if (event.target.closest('.save-icon')) {
        event.preventDefault()

        const form = document.querySelector('.admin-form form')
        if (!form) return

        const formData = new FormData(form)
        const formDataJson = {}

        for (const [key, value] of formData.entries()) {
            formDataJson[key] = value !== '' ? value : null
        }

        const id = form.querySelector('[name="id"]')?.value ?? ''
        const url = id ? `${endpoint}/${id}` : endpoint
        const method = id ? 'PUT' : 'POST'
        delete formDataJson.id

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(formDataJson)
            })

            if (!response.ok) throw response

            const data = await response.json()

            if (data.table) document.querySelector('.table-wrapper').innerHTML = data.table
            if (data.form) document.querySelector('.form-wrapper').innerHTML = data.form

            dispatchNotice(data.message ?? 'Datos guardados correctamente', 'success')

        } catch (error) {
            if (error.status === 422) {
                const data = await error.json()
                showValidationErrors(data.errors ?? data.message)
                dispatchNotice('Hay errores de validación', 'error')
            }

            if (error.status === 500) {
                dispatchNotice('No se han podido guardar los datos', 'error')
            }
        }
    }

    if (event.target.closest('.clean-icon')) {
        event.preventDefault()
        resetForm()
    }

    if (event.target.closest('.tab')) {
        event.preventDefault()

        const clickedTab = event.target.closest('.tab')
        const tabName = clickedTab.dataset.tab

        document.querySelector('.admin-form .tab.active')?.classList.remove('active')
        clickedTab.classList.add('active')

        document.querySelector('.admin-form .tab-content.active')?.classList.remove('active')
        document.querySelector(`.admin-form .tab-content[data-tab="${tabName}"]`)?.classList.add('active')
    }

    if (event.target.closest('.close-validation-errors')) {
        event.preventDefault()
        closeValidationErrors()
    }

    if (event.target.closest('.edit-button')) {
        event.preventDefault()

        const id = event.target.closest('.edit-button').dataset.id

        try {
            const response = await fetch(`${endpoint}/${id}/edit`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })

            if (!response.ok) throw response

            const data = await response.json()

            if (data.form) document.querySelector('.form-wrapper').innerHTML = data.form

        } catch {
            dispatchNotice('No se han podido cargar los datos', 'error')
        }
    }

    if (event.target.closest('.delete-button')) {
        event.preventDefault()

        if (!confirm('¿Estás seguro de que quieres eliminar este registro?')) return

        const id = event.target.closest('.delete-button').dataset.id

        try {
            const response = await fetch(`${endpoint}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })

            if (!response.ok) throw response

            const data = await response.json()

            if (data.table) document.querySelector('.table-wrapper').innerHTML = data.table
            if (data.form) document.querySelector('.form-wrapper').innerHTML = data.form

            dispatchNotice(data.message ?? 'Registro eliminado', 'success')

        } catch {
            dispatchNotice('No se ha podido eliminar el registro', 'error')
        }
    }
})

document.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' && event.target.closest('.admin-form form')) {
        event.preventDefault()
    }
})

function resetForm () {
    const form = document.querySelector('.admin-form form')
    if (!form) return
    form.reset()
    form.querySelector('[name="id"]').value = ''
    closeValidationErrors()
}

function showValidationErrors (errors) {
    const wrapper = document.querySelector('.admin-form .validation-errors')
    const list = wrapper?.querySelector('ul')
    if (!wrapper || !list) return

    list.innerHTML = ''

    const items = Array.isArray(errors)
        ? errors
        : Object.values(errors).flat()

    items.forEach(error => {
        const li = document.createElement('li')
        li.textContent = typeof error === 'object' ? error.message : error
        list.appendChild(li)
    })

    wrapper.classList.add('active')
}

function closeValidationErrors () {
    document.querySelector('.admin-form .validation-errors')?.classList.remove('active')
}

function dispatchNotice (message, type = 'success') {
    document.dispatchEvent(new CustomEvent('notice', {
        detail: { message, type }
    }))
}