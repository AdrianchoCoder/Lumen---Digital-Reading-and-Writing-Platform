# Changelog de desarrollo — Lumen

Registro incremental. El más reciente va arriba.

---

## [Módulo 7] — Administrador (2026-07-22)

### Qué se implementó

- `AdminController` + vistas en `app/views/admin/`
- Panel `/admin` con resumen (solicitudes pendientes, usuarios, libros)
- Solicitudes: filtrar, **aprobar** (sube `users.role` a `escritor` en transacción) o **rechazar**
- Usuarios: buscar, cambiar rol, activar/desactivar (sin tocar la propia cuenta)
- Contenido: buscar historias, archivar o republicar
- Link **Admin** en sidebar solo para rol administrador
- Métodos nuevos en `WriterRequest`, `User`, `Book`

### Decisiones técnicas

- Aprobación atómica: `BEGIN` → review request → `setRole('escritor')` → `COMMIT`
- No se baja un admin a escritor al aprobar su propia solicitud hipotética
- CSRF en todas las acciones POST
- El usuario aprobado debe **cerrar sesión y volver a entrar** para refrescar el rol en la sesión
- Middleware de rutas formal sigue pendiente (módulo 8); gate actual = `requireMinRole`

### Cómo probar

1. Login admin: `admin@lumen.local` / `Admin123!`
2. Sidebar → **Admin** → Solicitudes
3. Con otro navegador/cuenta lector, envía solicitud en Ser escritor
4. Aprueba → en phpMyAdmin el usuario queda `escritor`
5. El lector cierra sesión, entra de nuevo → ve menú Escribir
6. Prueba Usuarios (desactivar) y Contenido (archivar)

### Commit de referencia

- Commit: `2597401`
- Rama: `main`

---

## [Módulo 6] — Área Escritor (2026-07-22)

### Qué se implementó

- `requireMinRole('escritor')` en el controlador base (niveles de `config.php`)
- `WriterController` + vistas en `app/views/writer/`
- Modelos ampliados: `Book` (CRUD autor) y nuevo `Community`
- Rutas bajo `/escribir/*`
- Sidebar: Escribir, Comunidades, Estadísticas, botón Nueva historia (solo escritor/admin)
- Mis libros: crear/editar historia (borrador/publicado/archivado)
- Capítulos: crear/editar (borrador/publicado), numeración automática
- Comunidades: crear y activar/desactivar
- Estadísticas simples (conteos de libros, capítulos, guardados en bibliotecas, seguidores, comunidades)

### Decisiones técnicas

- Admin también entra al área escritor (nivel 3 ≥ 2)
- Ownership: solo el autor edita sus libros/capítulos/comunidades
- CSRF en todos los POST de escritura
- Middleware dedicado (`RoleMiddleware`) se formaliza en el módulo 8; aquí ya hay gate por nivel
- Comunidades básicas (sin miembros/posts aún): suficiente para el alcance del módulo

### Cómo probar

1. Login: `escritor@lumen.local` / `Escritor123!` (o admin)
2. Sidebar → **Escribir** / **Nueva historia**
3. Crear historia → añadir capítulo → publicar ambos
4. Verla en Descubrir (si está publicada)
5. Crear una comunidad y revisar Estadísticas
6. Con un **lector**, `/escribir` debe redirigir a Inicio con error de permiso

### Commit de referencia

- Commit: `99dc2b9`
- Rama: `main`

---

## [Módulo 5] — Solicitud de escritor (2026-07-22)

### Qué se implementó

- Modelo `WriterRequest.php`
- `WriterRequestController` (ver estado + enviar solicitud)
- Vista `reader/writer-request.php`
- Rutas `GET/POST /solicitar-escritor`
- Enlace **Ser escritor** en el sidebar (solo rol `lector`)
- Validación de motivación (30–2000 caracteres), CSRF, anti-duplicado si hay solicitud pendiente
- Historial de solicitudes del usuario

### Decisiones técnicas

- Solo `lector` puede enviar; escritor/admin ven mensaje de que ya tienen acceso
- Si hay solicitud `pendiente`, no se permite otra
- Si fue `rechazado`, puede volver a solicitar
- La **aprobación y cambio de rol** quedan para el módulo 7 (Admin); aquí solo se crea el registro en `writer_requests`

### Cómo probar

1. Entra con una cuenta **lector**
2. Sidebar → **Ser escritor**
3. Escribe una motivación ≥ 30 caracteres y envía
4. Verifica en phpMyAdmin → `writer_requests` (status `pendiente`)
5. La página debe mostrar “pendiente” y ocultar el formulario

### Commit de referencia

- Commit: `488e54c`
- Rama: `main`

### Documentación tocada al cerrar (refuerzo)

Se acordó actualizar **toda** `docs/desarrollo/` en cada módulo (README, CHANGELOG, ESTUDIAR, PROMPT, RECOMENDACIONES, GIT), no solo ESTUDIAR.

---

## [Módulo 4] — Módulo Lector (2026-07-22)

### Qué se implementó

- Layout `app` con sidebar: Inicio, Descubrir, Biblioteca, Perfil
- `ReaderController` + `FollowController`
- Modelos `Book`, `Follow`, `Library`
- Tabla `library` (biblioteca personal) + parche `database/patch_modulo4.sql`
- Datos demo: escritora `luna_writes` y 2 historias publicadas con capítulos
- Seguir / dejar de seguir autores
- Guardar / quitar historias de biblioteca
- Lectura de capítulos publicados
- Edición de perfil propio (nombre visible + bio)
- `requireAuth()` en el controlador base

### Decisiones técnicas

- Biblioteca = tabla pivote `library (user_id, book_id)`; no existía en el módulo 2 y era necesaria
- Inicio autenticado en `/inicio`; `/` queda como portada pública
- Perfiles públicos en `/u/{username}`; el propio en `/perfil`
- CSRF en follow/unfollow y biblioteca
- Diseño sidebar funcional (estética final = módulo 9)

### Cómo probar

1. Si la BD ya existía: importar `database/patch_modulo4.sql` (o reimportar `lumen.sql`)
2. Login con un lector (o registrar uno nuevo)
3. Ir a Descubrir → abrir una historia → Guardar en biblioteca / Seguir autor
4. Revisar Biblioteca, Inicio (siguiendo) y Perfil

Cuentas demo útiles:
- Lector: la que registres tú
- Escritora: `escritor@lumen.local` / `Escritor123!`
- Admin: `admin@lumen.local` / `Admin123!`

### Commit de referencia

- Commit: `b7beee9`
- Rama: `main`

---

## [Módulo 3] — Autenticación (2026-07-22)

### Qué se implementó

- `Session.php` y `Csrf.php` en el núcleo
- Modelo `User.php` (buscar por id/email/username; crear lector)
- `AuthController`: registro, login, logout
- Vistas `auth/login.php` y `auth/register.php`
- Rutas: `GET/POST /login`, `GET/POST /register`, `POST /logout`
- Arranque de sesión + PDO en `public/index.php`
- Layout con navegación Entrar/Registrarse o usuario + cerrar sesión
- Flash messages de éxito/error

### Decisiones técnicas

- Registro siempre crea rol **`lector`**
- Contraseñas solo con `password_hash` / `password_verify`
- `session_regenerate_id(true)` tras login/registro (anti session fixation)
- CSRF en todos los formularios POST de auth
- Datos en sesión: id, username, email, display_name, role (sin password)
- Logout solo por POST + CSRF
- Assets del CSS con URL absoluta (`appUrl`) para que no se rompan en `/login`

### Cómo probar

1. `http://localhost/lumen/public/register` → crear cuenta (mín. 8 caracteres en contraseña)
2. Debe redirigir al inicio con sesión activa y rol lector
3. Cerrar sesión → `http://localhost/lumen/public/login`
4. Probar admin seed: `admin@lumen.local` / `Admin123!`

### Commit de referencia

- Commit: `02cc863`
- Rama: `main`

---

## [Módulo 2] — Base de datos MySQL (2026-07-22)

### Qué se implementó

- Script completo `database/lumen.sql` para importar en phpMyAdmin / MySQL (XAMPP)
- Base `lumen` con charset `utf8mb4`
- Tablas: `users`, `writer_requests`, `books`, `chapters`, `follows`, `communities`
- Claves foráneas, índices y usuario admin de demo
- URL de la app fijada a `http://localhost/lumen/public` (enlace en `htdocs`)

### Decisiones técnicas

- **PK `INT UNSIGNED AUTO_INCREMENT`**: más eficiente en joins e índices que UUID en MySQL/XAMPP escolar
- **Roles en ENUM** (`lector|escritor|administrador`): legible en phpMyAdmin; los niveles 1/2/3 siguen en `config.php` para el middleware
- **`ON DELETE CASCADE`** en libros, capítulos, follows y comunidades al borrar el dueño/usuario
- **`ON DELETE SET NULL`** en `writer_requests.reviewed_by`: se conserva el historial de solicitudes si se borra el admin
- **`follows`**: PK compuesta `(follower_id, followed_id)` + `CHECK` anti auto-seguimiento
- Seed admin: `admin@lumen.local` / `Admin123!` (solo para pruebas)

### Cómo probar / importar

**Opción A — phpMyAdmin**

1. XAMPP: Start Apache + MySQL
2. Abrir `http://localhost/phpmyadmin`
3. Importar → elegir `database/lumen.sql` → Continuar
4. Verificar que exista la BD `lumen` y las 6 tablas

**Opción B — ya importado por consola en este entorno** (si MySQL estaba activo)

1. Abrir `http://localhost/lumen/public`
2. El aviso de BD debería pasar a conexión correcta (HomeController)

### Commit de referencia

- Commit: `4cf2488`
- Rama: `main`

---

## [Módulo 1] — Estructura base MVC (2026-07-21)

### Qué se implementó

- Estructura de carpetas MVC sin framework (PHP OO + MySQL/XAMPP)
- `config/config.php` con app, DB, sesión y niveles de rol (lector=1, escritor=2, administrador=3)
- Núcleo en `app/core/`:
  - `Autoloader.php` — carga de clases por namespace
  - `Database.php` — PDO singleton
  - `Router.php` — rutas GET/POST con parámetros `{id}`
  - `Controller.php` — base con `view()`, `redirect()`, `json()`
- Front controller: `public/index.php`
- Rutas: `app/routes/web.php` (`GET /` → HomeController)
- Vista de prueba: `app/views/home/index.php` + layout `layouts/main.php`
- `.htaccess` en raíz y en `public/` para URLs amigables
- Placeholders para models, middleware, vistas auth/reader/writer/admin y `database/`

### Decisiones técnicas

- Carpetas en minúsculas + namespaces `App\...` con mapa explícito en el Autoloader
- Rutas fuera de `public/` (`app/routes/`)
- Middleware en `app/middleware/` (aún vacío; se llena en el módulo 8)
- CSS mínimo solo para smoke test; el diseño completo es el módulo 9
- PK recomendada para el SQL futuro: `INT UNSIGNED AUTO_INCREMENT` (pendiente confirmar en módulo 2)

### Cómo probar

1. XAMPP: Apache (+ MySQL opcional en este paso)
2. Proyecto bajo `htdocs` (ej. `C:\xampp\htdocs\lumen`)
3. Ajustar `app.url` en `config/config.php`
4. Abrir `http://localhost/lumen/public`
5. Esperado: pantalla “Núcleo MVC listo”; aviso de BD normal hasta el módulo 2

### Archivos principales tocados

```
.gitignore
.htaccess
app/core/*
app/controllers/HomeController.php
app/routes/web.php
app/views/layouts/main.php
app/views/home/index.php
config/config.php
config/config.example.php
public/index.php
public/.htaccess
public/assets/css/app.css
docs/desarrollo/*
```

### Commit de referencia

- Commit código módulo 1: `fb20bbc`
- Commit hash en changelog: `171053e`
- Rama: `main`

### Documentación de estudio / entrega (ampliación post módulo 1)

Se añadieron y enriquecieron en `docs/desarrollo/`:

- `ESTUDIAR.md` — guía compartida (tú + prima): conceptos, archivos a leer, preguntas de repaso
- `RECOMENDACIONES.md` — acuerdos: Git, cuándo documentar, entrega al final, presentación colegio
- `README.md` y `PROMPT-CONTINUIDAD.md` — ritual obligatorio de actualizar docs en cada módulo
- Acuerdo: la carpeta `docs/entrega/` se crea **cerca del cierre**, no ahora

---

## Plantilla para módulos siguientes

```markdown
## [Módulo N] — Título (AAAA-MM-DD)

### Qué se implementó
- ...

### Decisiones técnicas
- ...

### Cómo probar
- ...

### Commit de referencia
- Commit: abc1234
```
