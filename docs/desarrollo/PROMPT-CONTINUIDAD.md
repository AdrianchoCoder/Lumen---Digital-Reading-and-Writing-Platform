# Prompt de continuidad — Lumen

Copia y pega el bloque de abajo en el chat de Cursor cuando quieras retomar el desarrollo.

---

## Prompt listo para pegar

```
Actúa como desarrollador Full Stack senior. Estamos construyendo "Lumen" (colegio, Ingeniería de Software).

ANTES de generar código, lee TODA docs/desarrollo/ (README, CHANGELOG, ESTUDIAR, RECOMENDACIONES, GIT-PUNTOS-DE-GUARDADO y este prompt).

## Stack
PHP OO MVC puro, MySQL/XAMPP, HTML/CSS/JS vanilla
Roles: lector=1, escritor=2, administrador=3
URL: http://localhost/lumen/public
Seguridad: password_hash/verify, PDO, sesión, CSRF, htmlspecialchars
Middleware: RoleMiddleware (auth, guest, role:escritor, role:administrador) + requireMinRole en controladores

## Fuera de alcance
Logros y Mensajes.

## Estado
1–8 COMPLETADOS
9 SIGUIENTE — Integración del diseño visual completo:
- Modo oscuro por defecto + toggle claro
- Color principal morado/violeta (~#6C5CE7)
- Sidebar fija izquierda, iconografía outline minimalista
- Tipografía limpia sans-serif, whitespace generoso
- Bordes redondeados suaves, sin sombras pesadas
- Barra de búsqueda prominente arriba
- Badges de notificación morados
Aplicar sobre las vistas ya construidas (no rehacer la lógica).

## Entrega
Tras el módulo 9 (o cuando el usuario lo pida), preparar docs/entrega/ con guía limpia para la prima.

## Cómo trabajar
Un módulo a la vez; explicar; esperar confirmación; español.
Al cerrar actualiza TODOS los 6 archivos de docs/desarrollo/ + commit + push.

## Tarea ahora
MÓDULO 9: diseño visual completo según la identidad anterior. Explica y espera confirmación. Actualiza TODA la documentación.
```

---

## Notas para ti (humano)

- Chat nuevo → pega este prompt.
- Tras cada módulo: 6 docs + push.
