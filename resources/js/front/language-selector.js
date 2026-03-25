export default (() => {

    const languageSelector = document.querySelector(".language-selector");

    languageSelector?.addEventListener("change", async () => {

        const formData = new FormData();
        formData.append('language', languageSelector.value);
        formData.append('path', window.location.href);

        const response = await fetch(languageSelector.dataset.endpoint, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        if (response.ok) {
            const json = await response.json();
            window.location.href = json.path;
        }

    });

})();