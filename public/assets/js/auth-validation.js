/**
 * Validación en vivo de login/register.
 * Reglas alineadas con App\Core\AuthRules (PHP).
 */
(function () {
    var USERNAME_MIN = 3;
    var USERNAME_MAX = 20;
    var DISPLAY_MIN = 2;
    var DISPLAY_MAX = 40;
    var PASSWORD_MIN = 8;

    function parseDomains(form) {
        var raw = form.getAttribute('data-email-domains') || '';
        return raw.split(',').map(function (d) { return d.trim().toLowerCase(); }).filter(Boolean);
    }

    function setError(field, message) {
        var el = field.querySelector('[data-error]');
        if (!el) return;
        el.textContent = message || '';
        field.classList.toggle('is-invalid', !!message);
        field.classList.toggle('is-valid', !message && field.querySelector('input') && field.querySelector('input').value !== '');
    }

    function validateEmail(value, domains) {
        value = (value || '').trim();
        if (!value) return 'El correo es obligatorio.';
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            return 'Escribe un correo válido con @ (ejemplo: nombre@gmail.com).';
        }
        var domain = value.slice(value.lastIndexOf('@') + 1).toLowerCase();
        if (domains.indexOf(domain) === -1) {
            return 'Dominio no permitido. Usa Gmail, Hotmail, Outlook, Yahoo, etc.';
        }
        return '';
    }

    function passwordChecks(value) {
        return {
            length: value.length >= PASSWORD_MIN,
            lower: /[a-z]/.test(value),
            upper: /[A-Z]/.test(value),
            number: /\d/.test(value),
            special: /[^A-Za-z0-9]/.test(value)
        };
    }

    function validatePassword(value) {
        if (!value) return 'La contraseña es obligatoria.';
        var c = passwordChecks(value);
        if (!c.length) return 'Mínimo ' + PASSWORD_MIN + ' caracteres.';
        if (!c.lower) return 'Incluye al menos una letra minúscula.';
        if (!c.upper) return 'Incluye al menos una letra mayúscula.';
        if (!c.number) return 'Incluye al menos un número.';
        if (!c.special) return 'Incluye al menos un carácter especial (!@#$%…).';
        return '';
    }

    function updatePasswordRules(field, value) {
        var checks = passwordChecks(value || '');
        field.querySelectorAll('[data-rule]').forEach(function (li) {
            var key = li.getAttribute('data-rule');
            var ok = !!checks[key];
            li.classList.toggle('is-met', ok && value !== '');
            li.classList.toggle('is-unmet', value !== '' && !ok);
        });
    }

    function validateUsername(value) {
        value = (value || '').trim();
        if (!value) return 'El nombre de usuario es obligatorio.';
        if (value.length < USERNAME_MIN || value.length > USERNAME_MAX) {
            return 'Usuario: entre ' + USERNAME_MIN + ' y ' + USERNAME_MAX + ' caracteres.';
        }
        if (/^[0-9]/.test(value)) return 'No puede empezar con un número.';
        if (/^[^a-zA-Z]/.test(value)) return 'Debe empezar con una letra (A–Z).';
        if (!/^[a-zA-Z][a-zA-Z0-9_]*$/.test(value)) {
            return 'Solo letras, números y guion bajo (_). Sin espacios ni símbolos.';
        }
        return '';
    }

    function validateDisplayName(value) {
        value = (value || '').trim();
        if (!value) return 'El nombre visible es obligatorio.';
        if (value.length < DISPLAY_MIN || value.length > DISPLAY_MAX) {
            return 'Nombre visible: entre ' + DISPLAY_MIN + ' y ' + DISPLAY_MAX + ' caracteres.';
        }
        if (!/^[\p{L}]/u.test(value)) return 'El nombre visible debe empezar con una letra.';
        if (!/^[\p{L}][\p{L}\p{N}\s.'\-]*$/u.test(value)) {
            return 'Usa letras, espacios y (opcional) punto, apóstrofe o guion.';
        }
        return '';
    }

    function validateField(field, form, domains) {
        var type = field.getAttribute('data-validate');
        var input = field.querySelector('input');
        if (!type || !input) return true;

        var message = '';
        var value = input.value;

        if (type === 'email') {
            message = validateEmail(value, domains);
        } else if (type === 'password') {
            updatePasswordRules(field, value);
            message = validatePassword(value);
        } else if (type === 'password_confirm') {
            var pass = form.querySelector('[data-validate="password"] input');
            var passVal = pass ? pass.value : '';
            if (!value) message = 'Confirma tu contraseña.';
            else if (value !== passVal) message = 'Las contraseñas no coinciden.';
        } else if (type === 'username') {
            message = validateUsername(value);
        } else if (type === 'display_name') {
            message = validateDisplayName(value);
        }

        setError(field, message);
        return message === '';
    }

    function bindForm(form) {
        var domains = parseDomains(form);

        form.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var wrap = btn.closest('.password-field');
                var input = wrap ? wrap.querySelector('input') : null;
                if (!input) return;
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.setAttribute('aria-label', show ? 'Ocultar contraseña' : 'Mostrar contraseña');
                btn.classList.toggle('is-visible', show);
                var eye = btn.querySelector('.icon-eye');
                var eyeOff = btn.querySelector('.icon-eye-off');
                if (eye) eye.hidden = show;
                if (eyeOff) eyeOff.hidden = !show;
            });
        });

        form.querySelectorAll('.field[data-validate]').forEach(function (field) {
            var input = field.querySelector('input');
            if (!input) return;

            // Muestra estado al escribir / salir del campo
            input.addEventListener('input', function () {
                validateField(field, form, domains);
                if (field.getAttribute('data-validate') === 'password') {
                    var confirmField = form.querySelector('[data-validate="password_confirm"]');
                    if (confirmField && confirmField.querySelector('input').value !== '') {
                        validateField(confirmField, form, domains);
                    }
                }
            });
            input.addEventListener('blur', function () {
                validateField(field, form, domains);
            });
        });

        form.addEventListener('submit', function (e) {
            var ok = true;
            form.querySelectorAll('.field[data-validate]').forEach(function (field) {
                if (!validateField(field, form, domains)) ok = false;
            });
            if (!ok) {
                e.preventDefault();
                var firstBad = form.querySelector('.field.is-invalid input');
                if (firstBad) firstBad.focus();
            }
        });
    }

    document.querySelectorAll('form.auth-form').forEach(bindForm);
})();
