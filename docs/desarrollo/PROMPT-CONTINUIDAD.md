# Prompt de continuidad — Lumen

Copia y pega el bloque de abajo en el chat de Cursor cuando quieras retomar el desarrollo.

Actualiza este archivo al terminar cada módulo (cambia el “siguiente paso” y el resumen del estado).

---

## Prompt listo para pegar

```
Actúa como desarrollador Full Stack senior. Estamos construyendo "Lumen", una plataforma web tipo Wattpad.

## Stack
- Frontend: HTML5, CSS3, JavaScript vanilla
- Backend: PHP orientado a objetos, MVC puro (sin Laravel)
- BD: MySQL (XAMPP + phpMyAdmin)
- Roles jerárquicos en un solo campo users.role: lector=1, escritor=2, administrador=3

## Fuera de alcance por ahora
- Logros y Mensajes (no implementar)

## Seguridad (obligatoria en cada módulo que toque datos/formularios)
- password_hash / password_verify
- PDO + sentencias preparadas
- Sesión + middleware de roles cuando corresponda
- Sanitización anti-XSS
- CSRF en formularios de escritura/admin

## Estado actual del proyecto
Ya está completado el MÓDULO 1:
- Estructura MVC en app/, public/, config/, database/
- Autoloader, Database (PDO), Router, Controller base
- Front controller public/index.php
- HomeController + vista de smoke test
- Documentación de seguimiento en docs/desarrollo/

El seguimiento de cambios está en docs/desarrollo/ (README, CHANGELOG, este prompt).
Léelo antes de generar código nuevo.

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
- Al terminar: código del módulo, decisiones técnicas breves, y esperar mi confirmación antes del siguiente
- Actualizar docs/desarrollo/CHANGELOG.md y este prompt
- No asumir requisitos no dados; preguntar si algo no está claro
- PK recomendada salvo que diga lo contrario: INT UNSIGNED AUTO_INCREMENT

## Tarea ahora
Continúa con el MÓDULO 2: genera el script SQL completo database/lumen.sql con las tablas users, writer_requests, books, chapters, follows, communities (FKs, índices, estados de solicitudes). Explica brevemente las decisiones y espera confirmación antes del módulo 3.
```

---

## Notas para ti (humano)

- Si cambias de máquina o de chat, pega este prompt y Cursor recupera el hilo del plan.
- Después de cada módulo aprobado, pide: “actualiza el prompt de continuidad y haz commit + push”.
