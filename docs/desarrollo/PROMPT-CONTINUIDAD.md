# Prompt de continuidad — Lumen

Copia y pega el bloque de abajo en el chat de Cursor cuando quieras retomar el desarrollo.

---

## Prompt listo para pegar

```
Actúa como desarrollador Full Stack senior. Estamos construyendo "Lumen" (colegio, Ingeniería de Software).

ANTES de generar código, lee TODA la carpeta docs/desarrollo/ (README, CHANGELOG, ESTUDIAR, RECOMENDACIONES, GIT-PUNTOS-DE-GUARDADO y este prompt).

## Stack
PHP OO MVC puro, MySQL/XAMPP, HTML/CSS/JS vanilla
Roles: lector=1, escritor=2, administrador=3
URL: http://localhost/lumen/public
Seguridad: password_hash/verify, PDO, sesión, CSRF, htmlspecialchars
Gate de roles actual: Controller::requireMinRole() (middleware formal = módulo 8)

## Fuera de alcance
Logros y Mensajes. docs/entrega/ solo al final.

## Estado
1–6 COMPLETADOS (MVC, SQL, auth, lector, solicitud escritor, área escritor)
7 SIGUIENTE — Módulo Administrador: revisar writer_requests (aprobar/rechazar), subir rol a escritor, gestión básica de usuarios/contenido
8 Middleware de roles en rutas
9 Diseño visual completo

## Cómo trabajar
Un módulo a la vez; explicar; esperar confirmación; español.
Al cerrar CADA módulo actualiza TODOS:
1. README.md  2. CHANGELOG.md  3. ESTUDIAR.md
4. PROMPT-CONTINUIDAD.md  5. RECOMENDACIONES.md  6. GIT-PUNTOS-DE-GUARDADO.md
Luego commit + push.

## Tarea ahora
MÓDULO 7: panel administrador. Aprobar/rechazar solicitudes de escritor actualizando users.role, listar usuarios y moderación básica de contenido (p. ej. desactivar usuario o archivar libro). Explica y espera confirmación. Al terminar actualiza TODA docs/desarrollo/.
```

---

## Notas para ti (humano)

- Chat nuevo → pega este prompt.
- Tras cada módulo: docs completos + push.
