// const languageSelector = document.getElementById('language');

// languageSelector.addEventListener('change', async (event) => {

//     const language = event.target.value;
//     const path = window.location.href;

//     const formData = new FormData();
//     formData.append('language', language);
//     formData.append('path', path);

//     const response = await fetch('/change-language', {

//         method: 'POST',
//         headers: {
//             'X-CSRF-TOKEN': document
//                 .querySelector('meta[name="csrf-token"]')
//                 .getAttribute('content')
//         },
//         body: formData
//     });

//     const data = await response.json();

//     if (data.success) {
//         window.location.href = data.path;
//     }

// });
