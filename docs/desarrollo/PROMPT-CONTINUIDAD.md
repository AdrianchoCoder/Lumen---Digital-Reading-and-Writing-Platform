# Prompt de continuidad — Lumen

Copia y pega el bloque de abajo en el chat de Cursor cuando quieras retomar el desarrollo.

---

## Prompt listo para pegar

```
Actúa como desarrollador Full Stack senior. Estamos construyendo "Lumen" (colegio, Ingeniería de Software).

ANTES de generar código, lee toda la carpeta docs/desarrollo/ (README, CHANGELOG, ESTUDIAR, RECOMENDACIONES, GIT-PUNTOS-DE-GUARDADO y este prompt).

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
7 Administrador (aprobar writer_requests y subir rol)
8 Middleware de roles
9 Diseño visual completo

## Cómo trabajar
- Un módulo a la vez; explicar; esperar confirmación; español.
- Al cerrar CADA módulo debes actualizar TODOS estos archivos (no solo ESTUDIAR):
  1. docs/desarrollo/README.md (estado + commit)
  2. docs/desarrollo/CHANGELOG.md
  3. docs/desarrollo/ESTUDIAR.md
  4. docs/desarrollo/PROMPT-CONTINUIDAD.md (este archivo)
  5. docs/desarrollo/RECOMENDACIONES.md (nueva nota del módulo)
  6. docs/desarrollo/GIT-PUNTOS-DE-GUARDADO.md (tabla de commits)
- Luego commit + push a GitHub.

## Tarea ahora
MÓDULO 6: área escritor. Por ahora restringe por rol === escritor|administrador (middleware formal en módulo 8). Incluye gestión de mis libros/capítulos, comunidades básicas y estadísticas simples. Explica y espera confirmación. Al terminar, actualiza TODA la documentación de docs/desarrollo/.
```

---

## Notas para ti (humano)

- Chat nuevo → pega este prompt.
- Tras aprobar un módulo: pide explícitamente si hace falta, pero Cursor ya debe actualizar **todos** los docs + push.
