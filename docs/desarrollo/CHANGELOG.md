# Changelog de desarrollo — Lumen

Registro incremental. El más reciente va arriba.

---

## [Mejora 10g] — Ser escritor + popup de agradecimiento (2026-07-23)

### Objetivo
Hacer atractiva la solicitud de escritor (mismo nivel que Perfil) e informar con un popup al enviar.

### Cambios
- Hero motivador con beneficios (publicar, Descubrir, perfil de autor)
- Estados visuales: ya escritor / pendiente / rechazado / aprobado
- Formulario e historial rediseñados
- Popup al enviar: agradecimiento + espera de aceptación
- Flash: mensaje de agradecimiento en `WriterRequestController::store`
- Ajuste: popup de Perfil ahora dice **“Se ha actualizado correctamente tu perfil.”**
- Layout `app.php`: el flash de éxito en `/solicitar-escritor` no duplica banner (va al popup)

### Archivos
- `app/views/reader/writer-request.php`
- `app/controllers/WriterRequestController.php`
- `app/controllers/ReaderController.php` (texto popup perfil)
- `app/views/layouts/app.php`
- `public/assets/css/app.css` (`.writer-request-*`)

### Commit
- Commit: *(se rellena al hacer push)*

---

## [Mejora 10f] — Perfil + popup al guardar (2026-07-23)

### Objetivo
Pulir `/perfil` (y perfiles públicos `/u/{username}`) con una ficha atractiva y confirmar el guardado con un popup.

### Cambios
- Hero: avatar con inicial, nombre, @usuario, rol, bio, stats (seguidores / siguiendo / historias)
- Propio: formulario de edición; ajeno: Seguir / Dejar de seguir
- Historias publicadas en rejilla de portadas (o vacío pulido)
- Tras guardar: flash `Se ha actualizado correctamente tu perfil.` → **popup modal** (no banner duplicado en `/perfil`)
- Mensaje actualizado en `ReaderController::updateProfile`

### Archivos
- `app/views/reader/profile.php`
- `app/views/layouts/app.php` (oculta flash-ok de perfil cuando hay popup)
- `app/controllers/ReaderController.php`
- `public/assets/css/app.css` (`.profile-*`, `.app-popup*`)

### Commit
- Commit: `a79b209`

---

## [Mejora 10e] — Ficha de historia opción A (2026-07-23)

### Objetivo
Pulir `/libros/{id}` al nivel de Inicio/Biblioteca: que se sienta la “portada del producto” antes de leer.

### Cambios
- Hero horizontal: portada sintética (`--cover-hue`) + género, título, autor, sinopsis
- CTA **Empezar a leer** → primer capítulo (si existe)
- Acciones en fila: biblioteca (guardar/quitar) y seguir/dejar de seguir (CSRF intacto)
- Lista de capítulos en filas (número, título, “Leer”) con hover
- Vacío de capítulos con `empty-panel`
- Sin cambios de controlador/modelos

### Archivos
- `app/views/reader/book.php`
- `public/assets/css/app.css` (`.story-hero*`, `.chapter-list`, `.chapter-row*`)

### Commit
- Commit: `68cb6a7`

---

## [Mejora 10d] — Biblioteca rejilla de portadas (opción A) (2026-07-23)

### Objetivo
Pulir la vista Biblioteca al mismo nivel visual que Inicio: portadas en rejilla, no solo filas de texto.

### Cambios
- Cabecera tipo hero con conteo de historias y CTA a Descubrir
- Rejilla reutilizando `.book-grid` / `.story-card` / portadas con `--cover-hue`
- Chip de género cuando existe; vacío con panel y CTA
- Botón **Quitar** absoluto sobre la portada (formulario fuera del enlace, CSRF intacto)

### Archivos
- `app/views/reader/library.php`
- `public/assets/css/app.css` (`.library-hero`, `.library-card`, `.library-remove*`)

### Commit
- Commit: `853378b`

---

## [Mejora 10c] — Lectura de capítulo inmersiva (opción A) (2026-07-23)

### Qué se implementó (solo frontend)

- Vista `reader/chapter.php` rediseñada para lectura cómoda estilo Wattpad
- Barra superior (sticky): volver a la historia + título del libro
- Columna de lectura centrada, tipografía e interlineado pensados para leer
- Contenedor con acento morado suave; pie con botón “Volver a la historia”
- Sin cambios de controlador/modelos (sin prev/siguiente: no venían en los datos)

### Cómo probar

1. Login → Descubrir → abrir una historia → un capítulo  
2. Probar tema claro/oscuro y ventana estrecha  
3. Usar “Volver a la historia” arriba y abajo  

### Commit de referencia

- Commit: `0610c6d`
- Rama: `main`

---

## [Mejora 10b] — Descubrir opción B + logo en área logueada (2026-07-23)

### Qué se implementó (solo frontend)

- **Descubrir** rediseñado en estilo catálogo (opción B):
  - Cabecera + buscador destacado
  - Historias en **filas** (portada izquierda + título, autor, género, sinopsis)
  - Sección **Comunidad → Escritores** (chips con avatar): descubrir autores y abrir su perfil
- Logo oficial `public/assets/img/logo.png` en el **sidebar** del área logueada (separado del texto “Lumen”, como en landing/auth)

### Para qué está la sección Escritores (importante para la demo)

No es decorativa. Completa el flujo tipo Wattpad:

1. El usuario busca o navega historias en el catálogo.  
2. También puede encontrar **personas** (escritores) en la misma página.  
3. Al hacer clic va a `/u/{username}` → ver perfil / seguir / leer sus obras.

Así Descubrir no es solo “lista de libros”: también es puerta de entrada a la comunidad de autores.  
Datos: misma búsqueda `?q=` vía `User::searchWriters` (sin cambiar backend).

### Archivos

- `app/views/reader/discover.php`
- `app/views/layouts/app.php` (logo sidebar)
- `public/assets/css/app.css` (catálogo + sidebar brand)

### Cómo probar

1. Login → `/descubrir` (Ctrl+F5)  
2. Revisar filas de historias y chips de escritores  
3. Clic en un escritor → perfil  
4. Comprobar logo en el sidebar en Inicio/Descubrir/etc.

### Commit de referencia

- Commit: `044ea70`
- Rama: `main`

---

## [Mejora 10a] — Inicio logueado (UI tipo Wattpad) (2026-07-23)

### Qué se implementó (solo frontend)

- Cabecera de bienvenida con accesos a Descubrir y Biblioteca
- “Recién publicadas” en **rejilla de portadas** (color por id, chip de género)
- “Siguiendo” en **fila horizontal de avatares** (inicial + nombre)
- Estados vacíos con panel + CTA
- Sin cambios de modelos, controladores ni queries

### Cómo probar

1. Login → `http://localhost/lumen/public/inicio`
2. Tema claro/oscuro
3. Hover en portadas y chips de autores
4. Responsive: ventana estrecha

### Commit de referencia

- Commit: `12d3664`
- Rama: `main`

---

## [Mejora 9+h] — Ojito con Font Awesome dentro del campo (2026-07-23)

### Qué se implementó

- CDN **Font Awesome 6.5.2** en `layouts/main.php`
- Iconos `fa-eye` / `fa-eye-slash` en login y register
- Posición **absolute** a la derecha **dentro** del input (`padding-right` en el campo)
- Sin botón cuadrado aparte debajo del campo (el flex fallaba porque el input a 100% empujaba el icono a la línea siguiente)

### Cómo probar

1. Ctrl+F5 en `/login` y `/register` (hace falta internet la primera vez por el CDN)
2. El ojo debe verse **dentro** del campo, a la derecha
3. Al clic: muestra texto y cambia a ojo tachado

### Commit de referencia

- Commit: `c7cde0f`
- Rama: `main`

---

## [Mejora 9+g] — Fix ojito de contraseña (2026-07-23)

### Qué fallaba

- El SVG inline usaba `stroke` + `fill: none`; en la práctica solo se veían “dos puntos” (pupila) y el botón no quedaba integrado al campo.

### Qué se hizo

- Iconos reales en `public/assets/img/icons/eye.svg` y `eye-off.svg` (SVG relleno)
- Campo de contraseña con **flex**: input + botón ojito a la **derecha dentro del mismo marco**
- Login y register actualizados

### Opciones de iconos (referencia de estudio)

1. **Archivos SVG/PNG** en `assets` (lo usado ahora; fiable)  
2. **SVG inline** con `fill="currentColor"` (bien si el CSS no anula el trazo)  
3. **Librería** (Font Awesome / Lucide por CDN)  
4. **Emoji** (👁) — rápido, menos control de estilo  

### Commit de referencia

- Commit: `98517ff`
- Rama: `main`

---

## [Mejora 9+f] — UX compacta de formularios auth (2026-07-23)

### Qué se implementó

- Formularios login/register **más limpios**: sin párrafos de ayuda que generaban scroll
- Solo label + input + error (cuando aplica)
- Requisitos de contraseña en **una línea de chips** (`8+ · a-z · A-Z · 0-9 · símbolo`) que se ponen verdes al cumplirse
- Ojito real (SVG ojo / ojo tachado) **dentro del campo**, a la derecha
- Register: usuario y nombre visible en **dos columnas** en desktop
- Errores cortos; no se muestran “obligatorio” mientras el campo sigue vacío al escribir
- Las reglas de seguridad en PHP (`AuthRules`) **no cambian**

### Cómo probar

1. Ctrl+F5 en `/login` y `/register`
2. Comprobar menos scroll y chips de contraseña
3. Probar el ojito (mostrar/ocultar)
4. Validar dominio de correo y contraseña débil → error breve

### Commit de referencia

- Commit: `f5d54f2`
- Rama: `main`

---

## [Mejora 9+e] — Validaciones login/register (2026-07-22)

### Qué se implementó

- Clase compartida `app/core/AuthRules.php` (reglas PHP = reglas JS)
- Validación **en vivo** + al enviar: `public/assets/js/auth-validation.js`
- Labels y **hints visibles** antes de escribir en cada campo
- **Correo:** formato con `@` + dominio permitido (Gmail, Hotmail, Outlook, Yahoo, Live, iCloud, Proton, `lumen.local` para demos)
- **Contraseña:** mín. 8, mayúscula, minúscula, número, especial + checklist en vivo + **ojito** mostrar/ocultar
- **Register:** usuario (3–20, empieza con letra, solo `a-zA-Z0-9_`), nombre visible (2–40, empieza con letra), confirmar contraseña
- Servidor vuelve a validar todo (no confiar solo en el navegador)

### Cómo probar

1. `/login` y `/register` — lee los hints sin tocar nada  
2. Correo `hola@empresa.com` → error de dominio; `hola@gmail.com` → ok  
3. Usuario `1ana` o `_ana` → error; `ana_lee` → ok  
4. Contraseña débil → checklist en rojo; `Admin123!` → ok  
5. Ojito muestra/oculta contraseña  
6. Cuentas demo siguen: `admin@lumen.local` / `Admin123!`

### Commit de referencia

- Commit: `4412bab`
- Rama: `main`

---

## [Mejora 9+d] — Auth login/register + marca separada (2026-07-22)

### Qué se implementó

- **Landing navbar:** logo e imagen y el texto **Lumen** ya no van en un solo enlace/botón; son dos enlaces separados (`.landing-logo-link` + `.landing-brand-text`)
- **Login / Register** (`layouts/main.php`): mismo lenguaje visual que la landing
  - Logo `logo.png` al lado del texto Lumen, **sin agruparlos** en un solo botón
  - Fondo `backgroundLandingPages.jpeg` + velo suave (oscuro/claro)
  - Formulario en tarjeta semitransparente con blur (contraste con el fondo)
  - Hovers morados al estilo landing
- **Navbar auth contextual:**
  - En `/login`: se quitó el botón Entrar/Iniciar (ya estás ahí); queda **Registrarse**
  - En `/register`: el antiguo “Entrar” pasa a **Iniciar sesión**; no se muestra Registrarse
- Botones de envío del formulario con clase `auth-submit-btn` (hover coherente)

### Archivos clave

- `app/views/layouts/landing.php`
- `app/views/layouts/main.php`
- `app/views/auth/login.php`, `register.php`
- `public/assets/css/app.css` (secciones landing + auth)

### Cómo probar

1. Landing: logo y “Lumen” se ven separados (hovers independientes)
2. `/login`: fondo con imagen, logo + Lumen separados, solo Registrarse arriba
3. `/register`: mismo diseño, arriba **Iniciar sesión** (sin Entrar)
4. Tema claro/oscuro en ambas pantallas

### Commit de referencia

- Commit: `07430cb`
- Rama: `main`

---

## [Mejora 9+c] — Pulido landing: marca, hovers claro, carrusel (2026-07-22)

### Qué se implementó

- Navbar: vuelve el texto **Lumen** junto al `logo.png`
- Modo **claro**: hover de “Comenzar” e “Inicia sesión” con morado más oscuro (`#4f3dbd`) y texto blanco (mejor contraste); **modo oscuro sin cambios** en ese comportamiento base
- Carrusel: más padding vertical + hover más suave para que las tarjetas **no se recorten** al pasar el mouse
- Eliminado el watermark semitransparente “Lumen” del hero (casi invisible y competía con el fondo); se mantienen las tarjetas de comunidad

### Cómo probar

1. Ctrl+F5 en `http://localhost/lumen/public`
2. Ver “Lumen” al lado del logo
3. Tema claro: hover en Comenzar e Inicia sesión
4. Tema oscuro: confirmar que los hovers siguen bien
5. Hover en libros del carrusel: la tarjeta sube sin cortarse

### Commit de referencia

- Commit: `e996bd4`
- Rama: `main`

---

## [Mejora 9+b] — Logo, fondo y hovers de la landing (2026-07-22)

### Qué se implementó

- Logo real: `public/assets/img/logo.png` en el navbar (sin texto “Lumen” duplicado; el logo ya lo incluye)
- Fondo: `public/assets/img/backgroundLandingPages.jpeg` a pantalla completa, visible (velo suave, no opaco)
- Navbar: se quitó el enlace **Inicio** (era redundante); quedan tema + Iniciar sesión + Registro
- Hovers contrastados en botones, nav, libros del carrusel, footer y modal (brillo morado + elevación)
- Paneles semitransparentes en hero/carrusel para legibilidad sobre el fondo

### Archivos clave

- `app/views/layouts/landing.php`
- `app/views/home/index.php`
- `public/assets/css/app.css` (sección landing)
- `public/assets/img/logo.png`
- `public/assets/img/backgroundLandingPages.jpeg`

### Cómo probar

1. Sin sesión → `http://localhost/lumen/public` (Ctrl+F5)
2. Comprobar logo y libros del fondo a la derecha
3. Pasar el cursor por Registro, Comenzar, Iniciar sesión, libros y flechas del carrusel
4. Probar tema claro y oscuro

### Commit de referencia

- Commit: `2374778`
- Rama: `main`

---

## [Mejora 9+] — Landing page pública (2026-07-22)

### Qué se implementó

- Nueva portada pública en `/` inspirada en Wattpad, con identidad Lumen (morado `#6C5CE7` + tema oscuro/claro)
- Layout dedicado `app/views/layouts/landing.php` (no se tocó el layout `app` del área logueada)
- Navbar: marca **Lumen + logo** a la izquierda; **Inicio / Iniciar sesión / Registro** + toggle de tema a la derecha
- Hero con titular, CTA “Comenzar” → registro, y arte decorativo con “tarjetas de comunidad”
- Carrusel horizontal de libros **publicados** (`Book::latestPublished(12)`); clic abre modal de incentivo
- Modal: mensaje con el título del libro + botones a `/register` y `/login`
- Footer: legal (placeholders), comunidad, redes y copyright
- Espacio de logo: usa `public/assets/img/logo.png` si existe; si no, `logo-placeholder.svg`
- JS: `public/assets/js/landing.js` (scroll del carrusel + modal)
- CSS landing añadido al final de `public/assets/css/app.css`

### Qué NO se cambió (estructura preservada)

- Carpetas MVC (`app/controllers`, `models`, `views`, `core`, `routes`, etc.) intactas
- Login/registro siguen con layout `main.php`
- Usuario logueado en `/` sigue redirigiendo a `/inicio` (comportamiento previo)

### Decisiones técnicas

- Un layout separado evita ensuciar el sidebar del área autenticada
- Libros de prueba = los que ya existan en BD con `status = 'publicado'` (añadir más historias publicadas alimenta el carrusel)
- Enlaces legales/redes del footer son `#` por ahora (listos para URLs reales)
- Logo: colocar tu imagen en `public/assets/img/logo.png` (recomendado cuadrado ~80–128 px)

### Cómo probar

1. Cerrar sesión (o ventana privada) → `http://localhost/lumen/public`
2. Alternar tema claro/oscuro desde el navbar
3. Deslizar el carrusel; clic en un libro → modal; “Crear cuenta” / “Iniciar sesión”
4. Si no hay libros publicados, debe verse el mensaje vacío con enlace a registro
5. Con sesión iniciada, `/` debe redirigir a `/inicio`

### Commit de referencia

- Commit: `480779d`
- Rama: `main`

---

## [Módulo 9] — Diseño visual completo (2026-07-22)

### Qué se implementó

- Sistema de tema **oscuro por defecto** + **claro** (`data-theme="light"`, `localStorage`)
- Paleta con acento `#6C5CE7`, tipografía Outfit
- Sidebar fija con iconos outline, secciones Escritor/Admin
- Barra superior con **búsqueda** (envía a Descubrir) + toggle tema + badge de notificaciones (UI; módulo mensajes/notificaciones sigue fuera de alcance)
- Layouts `app.php` y `main.php` rediseñados
- `public/assets/css/app.css` reescrito; `public/assets/js/theme.js`
- Guía inicial de entrega en `docs/entrega/README.md`

### Decisiones técnicas

- Tema aplicado en `<head>` antes del CSS para evitar flash
- Notificaciones: solo indicador visual (no hay backend aún, como se acordó)
- No se reescribió la lógica de negocio; solo presentación
- Con el módulo 9 cierra el plan de 9 módulos del prompt original

### Cómo probar

1. `http://localhost/lumen/public` (portada) y login  
2. Área logueada: sidebar, búsqueda arriba, badge  
3. Botón sol/tema → alterna claro/oscuro y persiste al recargar  
4. Responsive: reduce la ventana (<860px)

### Commit de referencia

- Commit: `ccf6ceb`
- Rama: `main`

---

## [Módulo 8] — Middleware de roles (2026-07-22)

### Qué se implementó

- `app/middleware/RoleMiddleware.php`
- `Router` acepta 3er argumento: array de reglas por ruta
- Reglas: `auth`, `guest`, `role:escritor`, `role:administrador` (niveles de `config.php`)
- `app/routes/web.php` aplica middleware a todas las rutas sensibles
- Login/registro = `guest`; área lectora = `auth`; `/escribir/*` = `role:escritor`; `/admin/*` = `role:administrador`
- Se mantiene `requireMinRole` / `requireAuth` en controladores (segunda capa)

### Decisiones técnicas

- Jerarquía numérica: si eres admin (3) pasas `role:escritor` (2)
- El middleware corre **antes** de instanciar/ejecutar el controlador
- `guest` evita que un usuario logueado vea login/registro (redirige a `/inicio`)
- No se eliminó la validación en controladores a propósito (defensa en profundidad para el colegio)

### Cómo probar

**Importante:** escribe la URL **completa** en la barra (no pegues solo `escribir` estando en `/login`, porque el navegador arma `.../login/escribir` y da 404).

URLs correctas (copia y pega):

1. Sin sesión → `http://localhost/lumen/public/escribir` → te manda a login  
2. Sin sesión → `http://localhost/lumen/public/admin` → te manda a login  
3. Como lector (ya logueado) → mismas URLs → Inicio con “no tienes permiso”  
4. Como escritor → `.../escribir` OK; `.../admin` → sin permiso  
5. Como admin → ambas OK  
6. Logueado → `http://localhost/lumen/public/login` → redirige a `/inicio`

URL **incorrecta** (lo que salió en la prueba):  
`http://localhost/lumen/public/login/escribir` → 404 (esa ruta no existe; el middleware ni siquiera corre).

### Commit de referencia

- Commit: `990629c`
- Rama: `main`

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
