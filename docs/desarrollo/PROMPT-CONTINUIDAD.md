# Prompt de continuidad y hoja de ruta — Lumen

Usa el bloque de abajo cuando quieras que otra IA (Claude, Cursor, etc.) **organice el siguiente flujo** del software de forma escalable (tipo Wattpad), sin romper lo ya construido.

También sirve como continuidad corta al final del archivo.

---

## Prompt completo (pegar en Claude / Cursor)

```
Actúa como arquitecto de software + Product Designer + desarrollador Full Stack senior.

Proyecto académico: **Lumen** — plataforma digital de lectura y escritura estilo Wattpad
(colegio, Ingeniería de Software). El estudiante construye con IA y luego estudia el código;
hay que documentar y dejar puntos Git de guardado.

Responde siempre en **español**.

════════════════════════════════════
1) LEE ANTES DE PROPONER O CODIFICAR
════════════════════════════════════
Lee (en este orden):
- docs/desarrollo/README.md
- docs/desarrollo/CHANGELOG.md
- docs/desarrollo/ESTUDIAR.md
- docs/desarrollo/RECOMENDACIONES.md
- docs/desarrollo/GIT-PUNTOS-DE-GUARDADO.md
- docs/entrega/README.md
- app/routes/web.php
- database/lumen.sql
- config/config.php

No inventes carpetas nuevas ni rompas el MVC existente.

════════════════════════════════════
2) STACK Y REGLAS INQUEBRANTABLES
════════════════════════════════════
- PHP OO + MVC puro (sin Laravel/frameworks pesados)
- MySQL + XAMPP
- HTML/CSS/JS vanilla (Font Awesome solo donde ya se usa en auth)
- URL local: http://localhost/lumen/public
- Roles jerárquicos: lector=1, escritor=2, administrador=3
- Middleware: auth | guest | role:escritor | role:administrador
- Defensa en profundidad: middleware + requireAuth/requireMinRole en controladores
- Seguridad: PDO preparado, password_hash/password_verify, CSRF, sesiones, XSS escape
- Tema: oscuro por defecto + claro; acento #6C5CE7
- Estructura de carpetas actual: NO reorganizar “por estética”
- Al cerrar un bloque: actualizar los 6 archivos de docs/desarrollo/ + commit con sentido + push
- Commits: título + descripción ligados al cambio real de esa sesión

════════════════════════════════════
3) QUÉ YA ESTÁ HECHO (NO REHACER)
════════════════════════════════════
Plan módulos 1–9 COMPLETADO:
1. Núcleo MVC (Router, Controller, Database, Session, Csrf, Autoloader)
2. SQL lumen.sql (users, writer_requests, books, chapters, follows, communities, library)
3. Auth (registro como lector, login, logout)
4. Lector (inicio, descubrir, biblioteca, leer libro/capítulo, perfil, follow)
5. Solicitud a escritor
6. Escritor (historias, capítulos, comunidades básicas, stats UI)
7. Admin (solicitudes, usuarios, contenido)
8. RoleMiddleware en rutas
9. Diseño visual app (sidebar, búsqueda, tema)

Mejoras 9+ UI/UX COMPLETADAS:
- Landing pública estilo Wattpad (hero, carrusel libros publicados → modal auth, footer)
- Logo + fondo backgroundLandingPages + hovers
- Login/register alineados visualmente con landing
- Validaciones AuthRules (PHP) + auth-validation.js (correo lista blanca de dominios,
  contraseña fuerte, usuario/nombre visible, ojito Font Awesome DENTRO del campo)
- UI auth compacta (sin muros de texto; chips de contraseña)

Cuentas demo:
- admin@lumen.local / Admin123!
- escritor@lumen.local / Escritor123!

Layouts:
- landing.php → portada /
- main.php → login/register
- app.php → área logueada

Si hay sesión en /, redirige a /inicio.

════════════════════════════════════
4) QUÉ FALTA / HUECOS TIPO WATTPAD (PRIORIZAR)
════════════════════════════════════
Hoy hay base sólida, pero para que un usuario “quiera quedarse” como en Wattpad faltan
piezas de engagement y pulido de producto. Organiza un roadmap REALISTA y ESCALABLE.

Huecos típicos a evaluar (confirma contra el código; no asumas implementado):
- Comentarios en capítulos / reacciones (likes, votos)
- Mensajes / notificaciones reales (hoy puede haber badge UI sin backend)
- Progreso de lectura / “continuar leyendo”
- Portadas de libros (imágenes reales, no solo color/hue)
- Búsqueda y descubrimiento más ricos (tags, géneros, tendencias, ranking)
- Perfil de autor más atractivo (bio, obras, seguidores)
- Feed social (actividad de seguidos)
- Comunidades más completas (posts, membresía, reglas)
- Series / listas / colecciones
- Moderación avanzada y reportes
- Accesibilidad, performance, responsive fino en área logueada
- Onboarding post-registro (qué hacer primero)
- Consistencia visual área logueada vs landing (sin romper sidebar)

Principio: primero flujos que cierren el loop lector↔escritor↔comunidad;
luego “nice to have”.

════════════════════════════════════
5) TU TAREA AHORA (SOLO PLANIFICACIÓN)
════════════════════════════════════
NO empieces a codear todavía salvo que el usuario lo pida explícitamente.

Entrega un plan estructurado con:

A) Diagnóstico breve: qué ya vende la experiencia Wattpad y qué frena retención.
B) Mapa de flujos de usuario (lector, escritor, admin, visitante) en estados actuales.
C) Roadmap por FASES (Fase 10, 11, 12…) con:
   - objetivo de negocio/UX
   - features concretas
   - tablas/modelos/controladores/vistas tocados
   - riesgos (migración SQL, permisos, UX)
   - criterio de “hecho”
   - orden recomendado (dependencias)
D) Principios de escalabilidad para este stack (sin overengineering):
   - límites de capas MVC
   - cuándo sí crear tabla nueva vs ampliar existente
   - cómo evitar N+1 y controladores gordos
   - versionado de BD con patches SQL (como ya se hizo en módulos previos)
E) Propuesta de “MVP Wattpad usable” en 3–5 sprints cortos (bloques documentables).
F) Lista de preguntas al usuario (solo las necesarias) para desambiguar prioridades
   (colegio vs producto, tiempo, demo de exposición).

Formato preferido:
1. Resumen ejecutivo (10 líneas máx.)
2. Roadmap en tabla
3. Detalle de la siguiente fase recomendada (la más valiosa ahora)
4. Checklist de ritual docs/git al cerrar cada fase

════════════════════════════════════
6) CUANDO EL USUARIO PIDA IMPLEMENTAR
════════════════════════════════════
- Un bloque/fase a la vez
- Preguntar si algo no está claro
- No dañar encarpetado MVC
- Actualizar TODOS los docs/desarrollo
- Commit con mensaje claro (tipo: feat(reader): … / fix(auth): …) + push
- Explicar en ESTUDIAR.md para que el estudiante aprenda después

Meta de producto:
Que Lumen se sienta atractivo y usable como alternativa tipo Wattpad:
venir por la historia, quedarse por la conexión (lectura, escritura, seguimiento, comunidad).
```

---

## Prompt corto (retomar implementación)

```
Actúa como desarrollador Frontend senior. Proyecto Lumen (entrega colegio).
Lee docs/desarrollo/ antes de cambiar código.
Estado: módulos 1–9 + 9+…9+h + 10a Inicio + 10b Descubrir + 10c lectura de capítulo.
SOLO frontend esta semana. No features backend nuevas.
Stack: PHP MVC, MySQL/XAMPP, JS vanilla. URL http://localhost/lumen/public
Documentar 6 docs + commit/push al cerrar bloque. Español.
Tarea: [VISTA A PULIR AHORA]
```

---

## Notas

- Plan 1–9 cerrado; 9+ = auth/landing; 10a = Inicio logueado UI.
- Entrega: `docs/entrega/README.md`
- Demo: `admin@lumen.local` / `Admin123!` · `escritor@lumen.local` / `Escritor123!`
