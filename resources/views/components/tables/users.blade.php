@props(['records'])

<section class="admin-table">

    <div class="table__header">
        <div class="table__header__box">
            <button class="filter-button">
                <span class="tooltip">Filtrar</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 12V19.88C12.04 20.18 11.94 20.5 11.71 20.71C11.32 21.1 10.69 21.1 10.3 20.71L8.29 18.7C8.06 18.47 7.96 18.16 8 17.87V12H7.97L2.21 4.62C1.87 4.19 1.95 3.56 2.38 3.22C2.57 3.08 2.78 3 3 3H17C17.22 3 17.43 3.08 17.62 3.22C18.05 3.56 18.13 4.19 17.79 4.62L12.03 12H12" />
                </svg>
            </button>
        </div>
    </div>

    <div class="table__body">
        @foreach($records as $record)
            <div class="table-row">

                <div class="element-box__upper-row">
                    <button class="edit-button" data-endpoint="{{ route('users_edit', $record->id) }}">
                        <span class="tooltip">Editar</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"/>
                        </svg>
                    </button>

                    <button class="delete-button" data-endpoint="{{ route('users_destroy', $record->id) }}">
                        <span class="tooltip">Eliminar</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
                        </svg>
                    </button>
                </div>

                <div class="table-row__content">
                    <label>Name: {{ $record->name }}</label>
                    <label>Email: {{ $record->email }}</label>
                </div>

            </div>
        @endforeach
    </div>

    <div class="table__footer">
        <div class="table__footer-box">
            <div class="table-page-info">
                {{ $records->total() }} registros en total,
                mostrando {{ $records->perPage() }} por página
            </div>
        </div>
        <div class="table-page-controls">
            <button class="table-pagination-page first-page inactive" data-page="1">
                <span class="tooltip">Primera página</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M18.41,7.41L17,6L11,12L17,18L18.41,16.59L13.83,12L18.41,7.41M12.41,7.41L11,6L5,12L11,18L12.41,16.59L7.83,12L12.41,7.41Z" />
                </svg>
            </button>

            <button class="table-pagination-page prev-page inactive" data-page="1">
                <span class="tooltip">Página anterior</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z" />
                </svg>
            </button>

            <button class="table-pagination-page next-page inactive" data-page="1">
                <span class="tooltip">Página siguiente</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z" />
                </svg>
            </button>

            <button class="table-pagination-page last-page inactive" data-page="1">
                <span class="tooltip">Última página</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M5.59,7.41L7,6L13,12L7,18L5.59,16.59L10.17,12L5.59,7.41M11.59,7.41L13,6L19,12L13,18L11.59,16.59L16.17,12L11.59,7.41Z" />
                </svg>
            </button>
        </div>
    </div>
</section>
