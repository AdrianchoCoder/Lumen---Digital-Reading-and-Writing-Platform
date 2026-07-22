# Prompt de continuidad — Lumen

Copia y pega el bloque de abajo en el chat de Cursor cuando quieras retomar el desarrollo.

**Obligatorio al cerrar cada módulo:** actualizar este prompt, `CHANGELOG.md`, `ESTUDIAR.md`, la tabla de `README.md` y, si hay acuerdos nuevos, `RECOMENDACIONES.md`. Luego commit + push.

---

## Prompt listo para pegar

```
Actúa como desarrollador Full Stack senior. Estamos construyendo "Lumen" (colegio, Ingeniería de Software).

Lee docs/desarrollo/ antes de generar código. Documentación viva: CHANGELOG, ESTUDIAR, RECOMENDACIONES, este prompt.

## Stack
PHP OO MVC puro, MySQL/XAMPP, HTML/CSS/JS vanilla
Roles: lector=1, escritor=2, administrador=3
URL: http://localhost/lumen/public
Seguridad: password_hash/verify, PDO, sesión, CSRF, htmlspecialchars

## Fuera de alcance
Logros y Mensajes. docs/entrega/ solo al final.

## Estado
1–5 COMPLETADOS (MVC, SQL, auth, lector, solicitud de escritor)
6 SIGUIENTE — Módulo Escritor (Escribir, Comunidades, Estadísticas, Mis libros / Nueva historia)
7 Administrador (aprobar solicitudes writer_requests y subir rol)
8 Middleware de roles
9 Diseño visual completo

## Cómo trabajar
Un módulo a la vez; explicar; esperar confirmación; español; al cerrar actualizar docs + commit/push.

## Tarea ahora
MÓDULO 6: área escritor. Por ahora restringe por rol === escritor|administrador (middleware formal en módulo 8). Incluye gestión de mis libros/capítulos, comunidades básicas y estadísticas simples. Explica y espera confirmación.
```

---

## Notas para ti (humano)

- Chat nuevo → pega este prompt.
- Tras aprobar: “actualiza docs/desarrollo y haz commit + push”.
