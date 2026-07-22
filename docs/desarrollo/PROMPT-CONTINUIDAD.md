# Prompt de continuidad — Lumen

Copia y pega el bloque de abajo en el chat de Cursor cuando quieras retomar el desarrollo.

**Obligatorio al cerrar cada módulo:** actualizar este prompt, `CHANGELOG.md`, `ESTUDIAR.md`, la tabla de `README.md` y, si hay acuerdos nuevos, `RECOMENDACIONES.md`. Luego commit + push.

---

## Prompt listo para pegar

```
Actúa como desarrollador Full Stack senior. Estamos construyendo "Lumen", una plataforma web tipo Wattpad para un proyecto de colegio (Ingeniería de Software).

## Contexto humano
- El software lo desarrolla y estudia el usuario con Cursor.
- Su prima también debe poder estudiar el código, instalarlo y presentarlo.
- Toda la documentación viva está en docs/desarrollo/.
- ANTES de generar código nuevo, lee: docs/desarrollo/README.md, CHANGELOG.md, ESTUDIAR.md, RECOMENDACIONES.md y este prompt.

## Stack
- Frontend: HTML5, CSS3, JavaScript vanilla
- Backend: PHP orientado a objetos, MVC puro (sin Laravel)
- BD: MySQL (XAMPP + phpMyAdmin)
- Roles jerárquicos en un solo campo users.role: lector=1, escritor=2, administrador=3
- URL local: http://localhost/lumen/public (junction htdocs/lumen → repo)

## Fuera de alcance por ahora
- Logros y Mensajes (no implementar)

## Seguridad (obligatoria)
- password_hash / password_verify
- PDO + sentencias preparadas
- Sesión + CSRF en formularios POST
- Sanitización anti-XSS (htmlspecialchars en vistas)
- Middleware de roles cuando corresponda (módulo 8; por ahora checks puntuales si hace falta)

## Documentación (actualizar SIEMPRE al cerrar un módulo)
1. docs/desarrollo/CHANGELOG.md
2. docs/desarrollo/README.md — tabla de estado
3. docs/desarrollo/ESTUDIAR.md
4. docs/desarrollo/PROMPT-CONTINUIDAD.md
5. docs/desarrollo/RECOMENDACIONES.md — si hay acuerdos nuevos
6. Commit + push a GitHub

## Entrega limpia al colegio
- NO crear aún docs/entrega/. Se hace cerca del FINAL.
- Detalle: docs/desarrollo/RECOMENDACIONES.md

## Estado actual del proyecto
MÓDULO 1 COMPLETADO: núcleo MVC.
MÓDULO 2 COMPLETADO: database/lumen.sql + admin demo.
MÓDULO 3 COMPLETADO: Auth (Session, Csrf, User, AuthController, login/register/logout).

## Orden de módulos
1. Estructura base — COMPLETADO
2. Script SQL — COMPLETADO
3. Autenticación — COMPLETADO
4. Módulo Lector (Inicio, Descubrir, Biblioteca, Perfil, seguir/dejar de seguir) — SIGUIENTE
5. Solicitud de escritor
6. Módulo Escritor
7. Módulo Administrador
8. Middleware de roles en todas las rutas
9. Integración del diseño visual completo

## Cómo trabajar
- Un módulo a la vez
- Al terminar: explicar, decisiones breves, esperar confirmación
- No asumir requisitos no dados; preguntar si algo no está claro
- Responder en español

## Tarea ahora
Continúa con el MÓDULO 4: módulo Lector (Inicio, Descubrir, Biblioteca, Perfil, seguir/dejar de seguir). Reutiliza auth de sesión. Explica decisiones y espera confirmación antes del módulo 5. Al confirmar, actualiza docs/desarrollo/.
```

---

## Notas para ti (humano)

- Si abres un chat nuevo, pega este prompt completo.
- Después de aprobar un módulo, di: **“actualiza la documentación de docs/desarrollo y haz commit + push”**.
- Tu prima puede estudiar con `ESTUDIAR.md`.
