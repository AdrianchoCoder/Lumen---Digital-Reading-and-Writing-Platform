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
Gate actual: Controller::requireMinRole() — formalizar en módulo 8

## Fuera de alcance
Logros y Mensajes. docs/entrega/ solo al final.

## Estado
1–7 COMPLETADOS (MVC, SQL, auth, lector, solicitud, escritor, admin)
8 SIGUIENTE — Middleware de roles aplicado a rutas (RoleMiddleware + niveles 1/2/3), unificar protección de /escribir y /admin
9 Diseño visual completo (CSS morado/oscuro, sidebar, etc. según identidad visual)

## Cómo trabajar
Un módulo a la vez; explicar; esperar confirmación; español.
Al cerrar CADA módulo actualiza TODOS:
1. README.md  2. CHANGELOG.md  3. ESTUDIAR.md
4. PROMPT-CONTINUIDAD.md  5. RECOMENDACIONES.md  6. GIT-PUNTOS-DE-GUARDADO.md
Luego commit + push.

## Tarea ahora
MÓDULO 8: middleware de roles. Crea app/middleware/RoleMiddleware.php, intégralo al Router o a un pipeline claro, aplica niveles jerárquicos a las rutas sensibles, documenta. Explica y espera confirmación. Al terminar actualiza TODA docs/desarrollo/.
```

---

## Notas para ti (humano)

- Chat nuevo → pega este prompt.
- Tras cada módulo: los 6 docs + push.
