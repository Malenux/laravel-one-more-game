<div class="image-modal">

    <div class="image-modal__header">
        <h2>Biblioteca</h2>
        <button type="button" class="image-modal__close">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6z"/>
            </svg>
        </button>
    </div>

    <div class="image-modal__body">

        <div class="image-modal__grid">
            <div class="image-upload">

                <label for="image" class="image-modal__upload">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24">
                        <path d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h8v2H5v14h14v-7h2v7q0 .825-.587 1.413T19 21zm1-4h12l-3.75-5l-3 4L9 13zm12-7V5.825L16.4 7.4L15 6l4-4l4 4l-1.4 1.4L20 5.825V10z"/>
                    </svg>
                </label>

                <input
                    data-endpoint="{{ route('images_store') }}"
                    class="image-modal__upload-input"
                    type="file"
                    name="image"
                    id="image"
                    hidden
                >
            </div>
            
            @foreach ($images as $image)
                <div class="image-modal__item" data-filename="{{ $image->filename }}">
                    <img src="{{ route('images_thumb', $image->filename) }}">
                    <button
                        type="button"
                        class="image-modal__item-delete"
                        data-endpoint="{{ route('images_destroy', $image->filename) }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>

        <div class="image-modal__form">
            <input type="text" name="alt" placeholder="Alt">
            <input type="text" name="title" placeholder="Título">
        </div>

    </div>

    <div class="image-modal__actions">
        <button type="button" class="image-modal__btn image-modal__btn--confirm">
            <span>Seleccionar</span>
        </button>
    </div>

</div>
