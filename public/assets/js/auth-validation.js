/**
 * Validación en vivo de login/register (UI compacta).
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

    function setError(field, message, options) {
        options = options || {};
        var el = field.querySelector('[data-error]');
        var input = field.querySelector('input');
        var hasValue = !!(input && input.value !== '');
        var force = !!options.force;
        var soft = !!options.soft;

        // En escritura: no bombardear con "obligatorio" si el campo sigue vacío
        if (soft && !hasValue && !force) {
            if (el) el.textContent = '';
            field.classList.remove('is-invalid', 'is-valid');
            return message === '';
        }

        if (el) el.textContent = message || '';
        field.classList.toggle('is-invalid', !!message);
        field.classList.toggle('is-valid', !message && hasValue);
        return message === '';
    }

    function validateEmail(value, domains) {
        value = (value || '').trim();
        if (!value) return 'El correo es obligatorio.';
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            return 'Correo inválido (usa nombre@dominio.com).';
        }
        var domain = value.slice(value.lastIndexOf('@') + 1).toLowerCase();
        if (domains.indexOf(domain) === -1) {
            return 'Usa Gmail, Hotmail, Outlook, Yahoo u otro dominio permitido.';
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
        if (!c.lower) return 'Falta una minúscula.';
        if (!c.upper) return 'Falta una mayúscula.';
        if (!c.number) return 'Falta un número.';
        if (!c.special) return 'Falta un símbolo (!@#$…).';
        return '';
    }

    function updatePasswordStrength(field, value) {
        var checks = passwordChecks(value || '');
        var bar = field.querySelector('[data-password-strength]');
        if (!bar) return;
        bar.querySelectorAll('[data-rule]').forEach(function (chip) {
            var key = chip.getAttribute('data-rule');
            var ok = !!checks[key];
            chip.classList.toggle('is-met', ok && value !== '');
            chip.classList.toggle('is-unmet', value !== '' && !ok);
        });
        var allOk = value !== '' && checks.length && checks.lower && checks.upper && checks.number && checks.special;
        bar.classList.toggle('is-complete', allOk);
    }

    function validateUsername(value) {
        value = (value || '').trim();
        if (!value) return 'El usuario es obligatorio.';
        if (value.length < USERNAME_MIN || value.length > USERNAME_MAX) {
            return 'Usuario: ' + USERNAME_MIN + '–' + USERNAME_MAX + ' caracteres.';
        }
        if (/^[0-9]/.test(value)) return 'No puede empezar con número.';
        if (/^[^a-zA-Z]/.test(value)) return 'Debe empezar con una letra.';
        if (!/^[a-zA-Z][a-zA-Z0-9_]*$/.test(value)) {
            return 'Solo letras, números y _.';
        }
        return '';
    }

    function validateDisplayName(value) {
        value = (value || '').trim();
        if (!value) return 'El nombre visible es obligatorio.';
        if (value.length < DISPLAY_MIN || value.length > DISPLAY_MAX) {
            return 'Nombre: ' + DISPLAY_MIN + '–' + DISPLAY_MAX + ' caracteres.';
        }
        if (!/^[\p{L}]/u.test(value)) return 'Debe empezar con una letra.';
        if (!/^[\p{L}][\p{L}\p{N}\s.'\-]*$/u.test(value)) {
            return 'Caracteres no permitidos.';
        }
        return '';
    }

    function messageFor(type, value, form, domains) {
        if (type === 'email') return validateEmail(value, domains);
        if (type === 'password') return validatePassword(value);
        if (type === 'password_confirm') {
            var pass = form.querySelector('[data-validate="password"] input');
            var passVal = pass ? pass.value : '';
            if (!value) return 'Confirma tu contraseña.';
            if (value !== passVal) return 'Las contraseñas no coinciden.';
            return '';
        }
        if (type === 'username') return validateUsername(value);
        if (type === 'display_name') return validateDisplayName(value);
        return '';
    }

    function validateField(field, form, domains, options) {
        options = options || {};
        var type = field.getAttribute('data-validate');
        var input = field.querySelector('input');
        if (!type || !input) return true;

        if (type === 'password') {
            updatePasswordStrength(field, input.value);
        }

        var message = messageFor(type, input.value, form, domains);
        return setError(field, message, options);
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
                btn.setAttribute('title', show ? 'Ocultar contraseña' : 'Mostrar contraseña');
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

            input.addEventListener('input', function () {
                validateField(field, form, domains, { soft: true });
                if (field.getAttribute('data-validate') === 'password') {
                    var confirmField = form.querySelector('[data-validate="password_confirm"]');
                    if (confirmField && confirmField.querySelector('input').value !== '') {
                        validateField(confirmField, form, domains, { soft: true });
                    }
                }
            });

            input.addEventListener('blur', function () {
                validateField(field, form, domains, { force: input.value !== '' });
            });
        });

        form.addEventListener('submit', function (e) {
            var ok = true;
            form.querySelectorAll('.field[data-validate]').forEach(function (field) {
                if (!validateField(field, form, domains, { force: true })) ok = false;
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
