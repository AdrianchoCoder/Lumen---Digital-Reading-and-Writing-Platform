# Prompt de continuidad — Lumen

Copia y pega el bloque de abajo en el chat de Cursor cuando quieras retomar el desarrollo.

**Obligatorio al cerrar cada módulo:** actualizar este prompt, `CHANGELOG.md`, `ESTUDIAR.md`, la tabla de `README.md` y, si hay acuerdos nuevos, `RECOMENDACIONES.md`. Luego commit + push.

---

## Prompt listo para pegar

```
Actúa como desarrollador Full Stack senior. Estamos construyendo "Lumen", una plataforma web tipo Wattpad para un proyecto de colegio (Ingeniería de Software).

## Contexto humano
- Documentación viva en docs/desarrollo/ — léela antes de generar código.
- El usuario y su prima estudian con ESTUDIAR.md.

## Stack
- PHP OO MVC puro, MySQL/XAMPP, HTML/CSS/JS vanilla
- Roles: lector=1, escritor=2, administrador=3
- URL: http://localhost/lumen/public

## Fuera de alcance por ahora
- Logros y Mensajes

## Seguridad
- password_hash/verify, PDO preparado, sesión, CSRF en POST, htmlspecialchars en vistas

## Documentación al cerrar cada módulo
Actualizar CHANGELOG, README (estado), ESTUDIAR, este prompt, RECOMENDACIONES si aplica + commit/push.
NO crear docs/entrega/ aún.

## Estado
1 COMPLETADO — núcleo MVC
2 COMPLETADO — lumen.sql (+ library en módulo 4)
3 COMPLETADO — auth
4 COMPLETADO — lector (inicio, descubrir, biblioteca, perfil, follows, lectura)
5 SIGUIENTE — solicitud para convertirse en escritor (formulario + writer_requests)
6 Escritor
7 Administrador
8 Middleware de roles
9 Diseño visual completo

## Cómo trabajar
Un módulo a la vez; explicar; esperar confirmación; español.

## Tarea ahora
MÓDULO 5: solicitud de escritor (formulario del lector, tabla writer_requests, estados pendiente/aprobado/rechazado). La aprobación admin puede quedar en el módulo 7 si separas responsabilidades, pero el lector debe poder enviar la solicitud. Explica y espera confirmación. Luego actualiza docs/desarrollo/.
```

---

## Notas para ti (humano)

- Chat nuevo → pega este prompt.
- Tras aprobar un módulo: “actualiza docs/desarrollo y haz commit + push”.
