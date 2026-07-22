(function () {
    var carousel = document.getElementById('book-carousel');
    var prev = document.getElementById('carousel-prev');
    var next = document.getElementById('carousel-next');
    var modal = document.getElementById('auth-modal');
    var modalText = document.getElementById('auth-modal-text');

    function scrollByCard(direction) {
        if (!carousel) return;
        var card = carousel.querySelector('.book-card');
        var amount = card ? card.getBoundingClientRect().width + 16 : 220;
        carousel.scrollBy({ left: direction * amount * 2, behavior: 'smooth' });
    }

    if (prev) prev.addEventListener('click', function () { scrollByCard(-1); });
    if (next) next.addEventListener('click', function () { scrollByCard(1); });

    function openModal(title) {
        if (!modal) return;
        if (modalText && title) {
            modalText.textContent = '"' + title + '" te está esperando. Crea una cuenta o inicia sesión para leerla, guardarla y seguir al autor.';
        }
        modal.hidden = false;
        document.body.classList.add('modal-open');
    }

    function closeModal() {
        if (!modal) return;
        modal.hidden = true;
        document.body.classList.remove('modal-open');
    }

    document.querySelectorAll('[data-open-auth-modal]').forEach(function (el) {
        el.addEventListener('click', function () {
            openModal(el.getAttribute('data-book-title') || '');
        });
    });

    document.querySelectorAll('[data-close-modal]').forEach(function (el) {
        el.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });
})();
