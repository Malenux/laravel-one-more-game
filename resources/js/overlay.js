import store from './redux/store';

const overlay = document.querySelector('.overlay');

store.subscribe(() => {
    const { overlayActive } = store.getState().crud;
    overlay?.classList.toggle('active', overlayActive);
});