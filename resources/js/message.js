import store from './redux/store';
import { setMessage } from './redux/crud-slice';

let messageTimeout = null;

store.subscribe(() => {
    const { text, type } = store.getState().crud.message || {};
    if (!text) return;

    const spanMessage = document.querySelector('.message span');
    if (!spanMessage) return;
    spanMessage.textContent = text;

    const colorElement = document.querySelector('.color');
    const colorTimeElement = document.querySelector('.color-time');

    colorElement.classList.remove('success', 'error');
    colorElement.classList.add(type);

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

        store.dispatch(setMessage({ text: null, type: null }));
    }, 5000);
});