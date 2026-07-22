(function () {
    var root = document.documentElement;
    var key = 'lumen-theme';

    function current() {
        return root.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
    }

    function apply(theme) {
        if (theme === 'light') {
            root.setAttribute('data-theme', 'light');
        } else {
            root.removeAttribute('data-theme');
        }
        try {
            localStorage.setItem(key, theme);
        } catch (e) {}
    }

    var btn = document.getElementById('theme-toggle');
    if (btn) {
        btn.addEventListener('click', function () {
            apply(current() === 'light' ? 'dark' : 'light');
        });
    }
})();
