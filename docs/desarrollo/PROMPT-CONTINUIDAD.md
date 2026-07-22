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

## Seguridad (obligatoria cuando el módulo toque datos/formularios)
- password_hash / password_verify
- PDO + sentencias preparadas
- Sesión + middleware de roles cuando corresponda
- Sanitización anti-XSS
- CSRF en formularios de escritura/admin

## Documentación (actualizar SIEMPRE al cerrar un módulo)
1. docs/desarrollo/CHANGELOG.md
2. docs/desarrollo/README.md — tabla de estado
3. docs/desarrollo/ESTUDIAR.md — conceptos, archivos, preguntas de repaso
4. docs/desarrollo/PROMPT-CONTINUIDAD.md — este prompt
5. docs/desarrollo/RECOMENDACIONES.md — si hay acuerdos nuevos
6. Commit + push a GitHub

## Entrega limpia al colegio
- NO crear aún docs/entrega/.
- Se hace cerca del FINAL (módulo 9 / proyecto presentable).
- Detalle: docs/desarrollo/RECOMENDACIONES.md

## Estado actual del proyecto
MÓDULO 1 COMPLETADO: núcleo MVC, Router, PDO, front controller, docs.
MÓDULO 2 COMPLETADO: database/lumen.sql con users, writer_requests, books, chapters, follows, communities; admin demo; URL localhost/lumen/public.

## Orden de módulos
1. Estructura base — COMPLETADO
2. Script SQL — COMPLETADO
3. Autenticación (registro como lector, login, logout, sesiones) — SIGUIENTE
4. Módulo Lector
5. Solicitud de escritor
6. Módulo Escritor
7. Módulo Administrador
8. Middleware de roles en todas las rutas
9. Integración del diseño visual completo

## Cómo trabajar
- Un módulo a la vez
- Al terminar: explicar el módulo, decisiones breves, esperar confirmación
- No asumir requisitos no dados; preguntar si algo no está claro
- PK: INT UNSIGNED AUTO_INCREMENT (ya aplicado en SQL)
- Responder en español

## Tarea ahora
Continúa con el MÓDULO 3: autenticación completa (registro como lector, login, logout, sesiones PHP). Usa password_hash/password_verify, PDO preparado, vistas en app/views/auth/, AuthController, modelo User. Explica decisiones y espera confirmación antes del módulo 4. Al confirmar, actualiza docs/desarrollo/.
```

---

## Notas para ti (humano)

- Si abres un chat nuevo, pega este prompt completo.
- Después de aprobar un módulo, di: **“actualiza la documentación de docs/desarrollo y haz commit + push”**.
- Tu prima puede estudiar con `ESTUDIAR.md` sin necesidad de usar Cursor.
