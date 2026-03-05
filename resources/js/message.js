let messageTimeout = null;

document.addEventListener('message', function (event) {
    showMessage(event);
});

function showMessage (event) {
    const { message, type } = event.detail;

    const spanMessage = document.querySelector('.message span');
    if (!spanMessage) return;

    spanMessage.textContent = message;

    const colorElement = document.querySelector('.color');
    colorElement.classList.remove('success', 'error');
    colorElement.classList.add(type);

    const colorTimeElement = document.querySelector('.color-time');
    colorTimeElement.classList.remove('success', 'error');
    colorTimeElement.classList.add(type);

    colorTimeElement.style.transition = 'none';
    colorTimeElement.style.width = '0%';

    void colorTimeElement.offsetWidth;

    colorTimeElement.style.transition = 'width 5s linear';
    colorTimeElement.style.width = '100%';

    const messageElement = document.querySelector('.notice');
    messageElement.classList.add('active');

    if (messageTimeout) clearTimeout(messageTimeout);

    messageTimeout = setTimeout(() => {
        messageElement.classList.remove('active');
        colorTimeElement.style.transition = 'none';
        colorTimeElement.style.width = '0%';
        messageTimeout = null;
    }, 5000);
}