document.addEventListener('DOMContentLoaded', () => {
    const faqs = document.querySelectorAll('.faq');

    faqs.forEach(faq => {
        const question = faq.querySelector('.faq__question');

        question?.addEventListener('click', () => {
            const isActive = faq.classList.contains('active');
            faqs.forEach(f => f.classList.remove('active'));
            if (!isActive) faq.classList.add('active');
        });
    });
});