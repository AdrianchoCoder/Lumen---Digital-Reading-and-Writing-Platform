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

## Fuera de alcance por ahora
- Logros y Mensajes (no implementar)

## Seguridad (obligatoria cuando el módulo toque datos/formularios)
- password_hash / password_verify
- PDO + sentencias preparadas
- Sesión + middleware de roles cuando corresponda
- Sanitización anti-XSS
- CSRF en formularios de escritura/admin

## Documentación (actualizar SIEMPRE al cerrar un módulo)
1. docs/desarrollo/CHANGELOG.md — qué se hizo, decisiones, cómo probar, hash commit
2. docs/desarrollo/README.md — tabla de estado de módulos
3. docs/desarrollo/ESTUDIAR.md — ampliar guía de estudio (conceptos, archivos a leer, preguntas de repaso) para el usuario y su prima
4. docs/desarrollo/PROMPT-CONTINUIDAD.md — este prompt (estado + siguiente módulo)
5. docs/desarrollo/RECOMENDACIONES.md — solo si hay acuerdos/consejos nuevos
6. Commit + push a GitHub (punto de guardado)

## Entrega limpia al colegio
- NO crear aún docs/entrega/ ni la guía final de empaquetado.
- Esa guía se hace cerca del FINAL (módulo 9 / proyecto presentable).
- Mientras tanto, docs/desarrollo/ es el material de estudio y seguimiento.
- Detalle del acuerdo: docs/desarrollo/RECOMENDACIONES.md

## Estado actual del proyecto
MÓDULO 1 COMPLETADO:
- Estructura MVC en app/, public/, config/, database/
- Autoloader, Database (PDO), Router, Controller base
- Front controller public/index.php
- HomeController + vista de smoke test
- docs/desarrollo/ con README, CHANGELOG, ESTUDIAR, RECOMENDACIONES, PROMPT, GIT

## Orden de módulos
1. Estructura base — COMPLETADO
2. Script SQL completo (database/lumen.sql) — SIGUIENTE
3. Autenticación
4. Módulo Lector
5. Solicitud de escritor
6. Módulo Escritor
7. Módulo Administrador
8. Middleware de roles en todas las rutas
9. Integración del diseño visual completo

## Cómo trabajar
- Un módulo a la vez
- Al terminar: mostrar/explicar el módulo, decisiones técnicas breves, esperar confirmación antes del siguiente
- No asumir requisitos no dados; preguntar si algo no está claro
- PK recomendada salvo indicación contraria: INT UNSIGNED AUTO_INCREMENT
- Responder en español

## Tarea ahora
Continúa con el MÓDULO 2: genera el script SQL completo database/lumen.sql con las tablas users, writer_requests, books, chapters, follows, communities (FKs, índices, estados de solicitudes). Explica brevemente las decisiones y espera confirmación antes del módulo 3. Al confirmar el módulo 2, actualiza toda la documentación de docs/desarrollo/ según la lista de arriba.
```

---

## Notas para ti (humano)

- Si abres un chat nuevo, pega este prompt completo.
- Después de aprobar un módulo, di: **“actualiza la documentación de docs/desarrollo y haz commit + push”**.
- Tu prima puede estudiar con `ESTUDIAR.md` sin necesidad de usar Cursor.
