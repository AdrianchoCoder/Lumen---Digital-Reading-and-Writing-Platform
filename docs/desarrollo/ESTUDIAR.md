# Guía de estudio — Lumen (tú + tu prima)

Material para **entender el código**, no solo ejecutarlo.  
Se amplía al terminar cada módulo. Ambos pueden usar el mismo documento.

Cómo estudiar:

1. Leer la sección del módulo  
2. Abrir en el editor los archivos listados  
3. Explicar en voz alta (o por escrito) las “preguntas de repaso”  
4. Si no pueden responderlas, releer el CHANGELOG y el código

---

## Mapa rápido del proyecto (visión general)

```
public/          → lo único que el navegador debe llamar (entrada)
app/controllers/ → qué hacer ante cada URL
app/models/      → datos / base de datos (aún vacío)
app/views/       → HTML que ve el usuario
app/core/        → motor: router, PDO, controlador base, autoload
app/routes/      → lista de URLs
config/          → nombre app, MySQL, roles
database/        → scripts SQL (pendiente módulo 2)
docs/desarrollo/ → seguimiento y estudio (esta carpeta)
```

Flujo de una petición:

```
Navegador → public/index.php → Router → Controller → Vista (HTML)
                              ↘ (más adelante) Model → MySQL
```

---

## Módulo 1 — Estructura base MVC (completado)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| MVC | Separar datos (Model), pantallas (View) y orquestación (Controller) |
| Front controller | Toda petición pasa por `public/index.php` |
| Router | Decide qué controlador/acción corresponde a la URL |
| PDO / Database | Conexión segura a MySQL (aún sin tablas) |
| Autoloader | PHP encuentra solos los archivos de las clases |
| Config | Ajustes del entorno sin mezclarlos con la lógica |
| Roles en config | Niveles 1/2/3 listos para el middleware futuro |

### Archivos para abrir y leer (en este orden)

1. `public/index.php` — arranque  
2. `app/routes/web.php` — ruta `/`  
3. `app/controllers/HomeController.php` — acción de prueba  
4. `app/core/Router.php` — cómo se elige la ruta  
5. `app/core/Controller.php` — cómo se renderiza una vista  
6. `app/core/Database.php` — cómo se conecta PDO  
7. `app/core/Autoloader.php` — cómo se cargan las clases  
8. `config/config.php` — qué se configura  
9. `app/views/layouts/main.php` + `app/views/home/index.php` — HTML  

### Preguntas de repaso (módulo 1)

- ¿Por qué `app/` no debería ser la carpeta pública del servidor?  
- ¿Qué hace el Router cuando entras a `/`?  
- ¿Qué diferencia hay entre `Controller.php` y `HomeController.php`?  
- ¿Por qué el aviso de “base de datos” es normal todavía?  
- ¿Dónde están definidos los niveles lector / escritor / administrador?

### Práctica sugerida

- Cambiar el texto de `app/views/home/index.php` y recargar el navegador.  
- Explicar el cambio: “solo toqué la Vista; el Controlador sigue igual”.

---

## Módulo 2 — Base de datos (completado)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Base de datos `lumen` | Contenedor MySQL donde viven todas las tablas del proyecto |
| PK AUTO_INCREMENT | ID numérico que MySQL asigna solo; rápido en relaciones |
| FK (clave foránea) | Garantiza que un `author_id` exista en `users` |
| CASCADE | Si borras un libro, se borran sus capítulos automáticamente |
| ENUM de rol | En BD: `lector` / `escritor` / `administrador` (un solo campo) |
| `follows` asimétrico | A puede seguir a B sin que B siga a A |
| `writer_requests` | Pedido de un lector para subir a escritor; lo revisa un admin |

### Diagrama mental de relaciones

```
users ──┬──< writer_requests
        ├──< books ──< chapters
        ├──< communities
        └──< follows (follower / followed)
```

### Archivos / lugares para revisar

1. `database/lumen.sql` — script completo  
2. `config/config.php` — nombre de BD `lumen` y URL `http://localhost/lumen/public`  
3. phpMyAdmin → base `lumen` → pestaña Estructura de cada tabla  

### Preguntas de repaso (módulo 2)

- ¿Por qué usamos `INT` y no UUID como clave primaria aquí?  
- ¿Qué pasa con los capítulos si se elimina un libro?  
- ¿Qué estados puede tener una solicitud de escritor?  
- ¿Cómo se representa “Ana sigue a Luis” en la tabla `follows`?  
- ¿Dónde está el nivel numérico del rol (1/2/3): en la tabla o en config?

### Práctica sugerida

1. Importar (o reimportar) `lumen.sql` en phpMyAdmin.  
2. Abrir la tabla `users` y localizar el admin de demo.  
3. Explicar en voz alta la relación `books` → `chapters`.

### Credenciales de prueba (solo desarrollo)

- Email: `admin@lumen.local`  
- Contraseña: `Admin123!`  
- Rol: administrador  

---

## Módulo 3 — Autenticación (completado)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Sesión PHP | El servidor “recuerda” quién eres entre páginas (`$_SESSION`) |
| `password_hash` | Guarda un hash irreversible, nunca la contraseña en claro |
| `password_verify` | Compara la clave del login con el hash guardado |
| CSRF | Token secreto en el formulario para evitar envíos falsificados |
| Registro = lector | Toda cuenta nueva empieza con rol `lector` |
| Modelo `User` | Habla con la tabla `users` vía PDO preparado |
| AuthController | Orquesta formularios de login/registro/logout |

### Archivos para abrir y leer (en este orden)

1. `public/index.php` — arranca Session + Database  
2. `app/core/Session.php`  
3. `app/core/Csrf.php`  
4. `app/models/User.php`  
5. `app/controllers/AuthController.php`  
6. `app/views/auth/register.php` y `login.php`  
7. `app/routes/web.php`  

### Preguntas de repaso (módulo 3)

- ¿Dónde se guarda la contraseña y en qué forma?  
- ¿Qué hace `session_regenerate_id` después del login?  
- ¿Por qué el logout es POST y no un enlace GET?  
- ¿Qué rol obtiene un usuario al registrarse?  
- ¿Qué datos del usuario se guardan en la sesión?

### Práctica sugerida

1. Registrar un usuario nuevo y verlo en phpMyAdmin → tabla `users`.  
2. Confirmar que `password_hash` empieza por `$2y$`.  
3. Cerrar sesión e iniciar con el admin de demo.

---

## Módulo 4 — Lector (completado)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Sidebar / layout `app` | Navegación fija del área logueada (Inicio, Descubrir, etc.) |
| `requireAuth()` | Si no hay sesión, redirige a login |
| Descubrir | Busca libros publicados y escritores |
| Biblioteca | Historias que el lector guardó (`library`) |
| Follow asimétrico | Tú puedes seguir a alguien sin que te siga |
| Perfil `/u/user` | Ver a otro usuario; `/perfil` es el tuyo editable |

### Archivos para leer

1. `app/controllers/ReaderController.php`  
2. `app/controllers/FollowController.php`  
3. `app/models/Book.php`, `Follow.php`, `Library.php`  
4. `app/views/layouts/app.php`  
5. `app/views/reader/*`  
6. `database/patch_modulo4.sql` / sección `library` en `lumen.sql`  

### Preguntas de repaso

- ¿Qué pasa si entras a `/biblioteca` sin sesión?  
- ¿Cómo se guarda una historia en la biblioteca a nivel de tabla?  
- ¿Cuál es la diferencia entre `/perfil` y `/u/luna_writes`?  
- ¿Dónde se listan las personas que sigues?

### Práctica

1. Seguir a `luna_writes` y verla en Inicio.  
2. Guardar “Luces sobre el río” y verla en Biblioteca.  
3. Leer el capítulo 1.

---

## Módulo 5 — Solicitud de escritor (completado)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| `writer_requests` | Tabla donde el lector pide ser escritor |
| Estado `pendiente` | Enviada; espera al admin |
| Estado `aprobado` / `rechazado` | Lo define el admin (módulo 7) |
| Una pendiente a la vez | No puedes spamear solicitudes |
| Sidebar condicional | El link “Ser escritor” solo lo ven los lectores |

### Archivos para leer

1. `app/models/WriterRequest.php`  
2. `app/controllers/WriterRequestController.php`  
3. `app/views/reader/writer-request.php`  
4. Rutas en `app/routes/web.php`  

### Preguntas de repaso

- ¿Quién puede enviar la solicitud?  
- ¿Qué columnas clave tiene `writer_requests`?  
- ¿Qué pasa si ya tienes una solicitud pendiente?  
- ¿En qué módulo se aprueba y se cambia el rol?

### Práctica

1. Con un lector, envía una solicitud.  
2. Confírmala en phpMyAdmin.  
3. Recarga la página y verifica que no puedas enviar otra.

---

## Módulo 6 — Escritor (completado)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| `requireMinRole` | Bloquea si tu nivel de rol es menor al pedido |
| Área `/escribir` | Panel del escritor: hub, libros, comunidades, stats |
| Ownership | Solo editas lo que creaste (`author_id` / `owner_id`) |
| Estados de libro | `borrador`, `publicado`, `archivado` |
| Estados de capítulo | `borrador`, `publicado` (solo publicados se leen en Descubrir) |
| Comunidades | Espacios del escritor (versión básica sin feed) |
| Estadísticas | Conteos simples, no analytics avanzados |

### Archivos para leer

1. `app/core/Controller.php` → `requireMinRole` / `roleLevel`  
2. `app/controllers/WriterController.php`  
3. `app/models/Book.php` (métodos de autor)  
4. `app/models/Community.php`  
5. `app/views/writer/*`  
6. `app/routes/web.php` (bloque `/escribir`)  
7. `app/views/layouts/app.php` (links condicionales)  

### Preguntas de repaso

- ¿Qué roles pueden entrar a `/escribir`?  
- ¿Qué pasa si un lector intenta abrir esa URL?  
- ¿Cómo se asegura que no edites el libro de otro autor?  
- ¿Cuándo aparece una historia en Descubrir?  
- ¿Qué hace el botón de Nueva historia en el sidebar?

### Práctica

1. Con la cuenta escritora, crea “Mi prueba Lumen” y un capítulo publicado.  
2. Cierra sesión, entra como lector y búscalo en Descubrir.  
3. Vuelve como escritor y revisa Estadísticas (library_saves si alguien lo guardó).

---

## Módulo 7 — Administrador (completado)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Panel `/admin` | Zona solo para administradores |
| Aprobar solicitud | Cambia `writer_requests` a aprobado **y** `users.role` a escritor |
| Rechazar | Deja al usuario como lector; puede volver a pedir |
| Transacción PDO | O todo se guarda o nada (evita estados a medias) |
| Moderación | Archivar libro = ya no sale en Descubrir |
| Sesión vs BD | Tras aprobar, el usuario debe re-loguearse para ver el nuevo menú |

### Archivos para leer

1. `app/controllers/AdminController.php`  
2. `app/models/WriterRequest.php` (review, listByStatus)  
3. `app/models/User.php` (setRole, setActive, listForAdmin)  
4. `app/views/admin/*`  
5. Rutas `/admin/*` en `web.php`  

### Preguntas de repaso

- ¿Qué dos tablas se tocan al aprobar?  
- ¿Por qué se usa una transacción?  
- ¿Puede el admin desactivarse a sí mismo?  
- ¿Qué ve un lector si intenta entrar a `/admin`?

### Práctica

1. Solicitud pendiente → aprobar con admin.  
2. Re-login del usuario → comprobar menú Escribir.  
3. Archivar una historia y verificar que desaparece de Descubrir.

---

## Módulo 8 — Middleware de roles (completado)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Middleware | Filtro que corre **antes** del controlador |
| Niveles 1/2/3 | lector < escritor < administrador |
| `role:escritor` en la ruta | Solo entran nivel ≥ 2 |
| `auth` / `guest` | Con sesión / sin sesión |
| Defensa en profundidad | Middleware + chequeo en controlador |

### Archivos para leer

1. `app/middleware/RoleMiddleware.php`  
2. `app/core/Router.php` (bucle de middleware en `dispatch`)  
3. `app/routes/web.php` (arrays `$auth`, `$writer`, `$admin`)  
4. `config/config.php` → clave `roles`  
5. `Controller::requireMinRole` (segunda capa)  

### Preguntas de repaso

- ¿En qué momento se ejecuta el middleware respecto al controlador?  
- ¿Por qué un administrador puede entrar a `/escribir`?  
- ¿Qué regla usan login y registro?  
- ¿Qué pasa si quitas el middleware de una ruta de admin pero dejas `requireMinRole`?

### Práctica

1. Cierra sesión. En la barra pega exactamente:  
   `http://localhost/lumen/public/escribir`  
   Debe llevarte a login (no uses `.../login/escribir`).  
2. Entra como lector e intenta de nuevo esa misma URL completa (y `/admin`).  
3. Entra como escritor e intenta `http://localhost/lumen/public/admin`.  
4. Abre `web.php` y señala tres rutas con reglas distintas.

---

## Módulo 9 — Diseño visual (completado)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Design tokens | Variables CSS (`--accent`, `--bg`, etc.) |
| Tema claro/oscuro | `data-theme` + `localStorage` (`theme.js`) |
| Layout `app` | Sidebar + top chrome + contenido |
| Iconos outline | SVG en el sidebar, estilo minimalista |
| Separación | El CSS no cambia la lógica PHP/MVC |

### Archivos para leer

1. `public/assets/css/app.css`  
2. `public/assets/js/theme.js`  
3. `app/views/layouts/app.php`  
4. `app/views/layouts/main.php`  
5. `docs/entrega/README.md`  

### Preguntas de repaso

- ¿Dónde se define el color morado principal?  
- ¿Cómo recuerda el navegador si elegiste tema claro?  
- ¿La búsqueda de arriba a qué ruta envía?  

### Práctica

1. Cambia a tema claro, recarga y confirma que se mantiene.  
2. Busca “fantasía” desde la barra superior.  
3. Revisa el sidebar en móvil/ventana estrecha.

---

## Módulo 9+ — Mejoras posteriores (fuera del plan)

_El plan 1–9 terminó. Los siguientes cambios son mejoras o pedidos del colegio._

---

## Mejora 9+ — Landing page (2026-07-22)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Layout `landing` | HTML público (nav + footer + modal) distinto del layout `app` logueado |
| Portada vs app | Visitantes ven marketing; usuarios con sesión van a `/inicio` |
| Carrusel | Lista horizontal de libros publicados; el clic no abre el libro, pide auth |
| Modal de incentivo | Popup JS que empuja a login/registro sin romper MVC |
| Logo | Slot en `landing.php`; archivo `logo.png` o placeholder SVG |

### Archivos para leer (orden sugerido)

1. `app/controllers/HomeController.php` — elige layout `landing` y carga libros  
2. `app/views/layouts/landing.php` — navbar, footer, modal  
3. `app/views/home/index.php` — hero + carrusel  
4. `public/assets/js/landing.js` — scroll y modal  
5. Sección “Landing pública” al final de `public/assets/css/app.css`  

### Flujo mental

```
GET /  →  HomeController::index
         ├─ si hay sesión → redirect /inicio
         └─ si no → vista home/index + layout landing
                    + Book::latestPublished(12)
                    + clic libro → modal → /login o /register
```

### Preguntas de repaso

- ¿Por qué hay un layout `landing` aparte de `app` y `main`?  
- ¿Qué pasa si entras a `/` estando logueado?  
- ¿De dónde salen los libros del carrusel?  
- ¿Dónde pones tu logo real?

### Práctica

1. Sin sesión, abre la landing y prueba el modal de un libro.  
2. Publica (o usa) una historia de prueba y recarga: debe aparecer en el carrusel.  
3. Confirma `logo.png` en el navbar y el fondo `backgroundLandingPages.jpeg` (libros a la derecha).  
4. Pasa el cursor por botones/nav/libros: debe notarse el hover morado.

---

## Mejora 9+b — Logo, fondo y hovers (2026-07-22)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Fondo CSS | `background-image` + gradiente suave (no tapa la foto) |
| Legibilidad | Paneles `backdrop-filter` en hero/carrusel |
| Hover landing | Clases `landing-btn`, `landing-interactive`, etc. solo en la portada |
| Assets | Imágenes en `public/assets/img/` servidas por Apache |

### Archivos

1. `public/assets/img/logo.png`  
2. `public/assets/img/backgroundLandingPages.jpeg`  
3. Sección landing en `app.css`  

---

## Mejora 9+c — Pulido UI landing (2026-07-22)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Marca en navbar | Logo + `.landing-brand-text` (“Lumen”) |
| Hover por tema | Reglas `[data-theme="light"] …` solo afectan el modo claro |
| Recorte del carrusel | `overflow-x: auto` recorta el eje Y; se compensa con **padding** vertical |
| Watermark hero | Se eliminó `.hero-mark` para no tapar/competir con el fondo |

### Preguntas de repaso

- ¿Por qué el hover de Comenzar en claro usa un morado más oscuro?  
- ¿Qué propiedad del carrusel evitaba ver bien el hover?  
- ¿Dónde está el nombre “Lumen” en el HTML del navbar?

---

## Mejora 9+d — Login / Register alineados con la landing (2026-07-22)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Marca separada | Logo y texto son **dos** `<a>`; no un solo botón compuesto |
| Layout `main` | Sigue siendo el de auth; solo cambió presentación |
| Nav contextual | Según `$currentPath` se oculta Entrar en login o se muestra Iniciar sesión en register |
| Fondo auth | Misma imagen que la landing + gradiente; la tarjeta `.guest-shell` contrasta |

### Archivos para leer

1. `app/views/layouts/main.php`  
2. `app/views/layouts/landing.php` (comparar marca separada)  
3. CSS `.auth-body` / `.guest-shell` en `app.css`  

### Práctica

1. Abre `/login` y `/register` y compara el navbar superior.  
2. Alterna tema claro/oscuro.  
3. En la landing, pasa el mouse solo por el logo y solo por “Lumen”.

---

## Mejora 9+e — Validaciones de formularios auth (2026-07-22)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Doble validación | JS mejora UX; PHP es la verdad (seguridad) |
| `AuthRules` | Una sola fuente de reglas en el servidor |
| Dominios de correo | Lista blanca (no cualquier dominio) |
| Checklist contraseña | Feedback visual mientras escribes |
| Ojito | `type="password"` ↔ `type="text"` |

### Archivos para leer (orden)

1. `app/core/AuthRules.php`  
2. `app/controllers/AuthController.php`  
3. `public/assets/js/auth-validation.js`  
4. `app/views/auth/login.php` y `register.php`  

### Preguntas de repaso

- ¿Por qué se permite `lumen.local`?  
- ¿Qué pasa si desactivas JavaScript?  
- ¿Por qué el usuario no puede empezar con número?

### Práctica

1. Intenta registrar `9user` y un correo `@empresa.com`.  
2. Escribe una contraseña y mira cómo se ponen verdes las reglas.  
3. Usa el ojito en login.

---

## Mejora 9+f — UX compacta auth (2026-07-23)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Menos texto fijo | Labels + placeholder; errores solo cuando fallan |
| Chips de fuerza | Una fila compacta sustituye la lista larga |
| Ojito en el input | Botón absoluto a la derecha del campo |
| Menos scroll | Dos columnas (usuario/nombre) + gaps menores |

### Idea de diseño

Primero UX limpia; la seguridad sigue en `AuthRules` + el mismo JS, solo cambia cómo se muestra.

---

## Mejora 9+g — Ojito de contraseña corregido (2026-07-23)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Por qué falló el SVG | `fill: none` + stroke mal aplicado → solo se veían puntos |
| Solución usada | Archivos `eye.svg` / `eye-off.svg` + layout **flex** del campo |
| Alternativas | Inline SVG, icon font/CDN, emoji |

### Archivos

1. `public/assets/img/icons/eye.svg`  
2. `public/assets/img/icons/eye-off.svg`  
3. CSS `.password-field` (flex)  
4. `login.php` / `register.php`  

---

## Mejora 9+h — Font Awesome dentro del input (2026-07-23)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| CDN | Font Awesome se carga desde internet en el `<head>` de `main.php` |
| Iconos | `fa-eye` y `fa-eye-slash` |
| Posición | `position: absolute; right: …` sobre `.password-field` |
| Por qué no flex | Un `input` al 100% de ancho empuja el botón a la fila de abajo |

### Práctica

1. Inspecciona el botón del ojito en DevTools: debe estar encima del input.  
2. Desconecta la red: el icono puede no cargar (dependencia CDN).

---

## Mejora 10a — Inicio logueado (2026-07-23)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Solo vista/CSS | Los datos vienen igual del controlador; cambió la presentación |
| Portadas fake | Gradiente con `--cover-hue` a partir del id del libro |
| Follow rail | Scroll horizontal de autores seguidos |
| Empty panel | Estado vacío con CTA a Descubrir |

### Archivos

1. `app/views/reader/home.php`  
2. CSS `.home-hero`, `.book-grid`, `.follow-rail` en `app.css`  

### Práctica

1. Entra a `/inicio` y revisa hover de portadas.  
2. Si no sigues a nadie, prueba el CTA del vacío.

---

## Mejora 10b — Descubrir catálogo + Escritores + logo sidebar (2026-07-23)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Opción B | Historias en filas (portada + texto), no rejilla |
| Sección Escritores | Descubrir **autores** y abrir perfil; no es adorno |
| Misma búsqueda | `?q=` alimenta libros y escritores |
| Logo sidebar | `logo.png` + texto Lumen separados en `app.php` |

### Para la exposición (frase lista)

“En Descubrir el usuario encuentra historias en formato catálogo y, abajo, escritores para ir a su perfil y seguirlos; así conectamos lectura y comunidad.”

### Archivos

1. `app/views/reader/discover.php`  
2. `app/views/layouts/app.php`  
3. CSS `.catalog-row`, `.writer-chips`, `.sidebar-brand`  

### Práctica

1. Busca un género y mira resultados en filas.  
2. Haz clic en un chip de escritor.  
3. Confirma el logo en el menú lateral.

---

## Mejora 10c — Lectura de capítulo (2026-07-23)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Lectura inmersiva | Columna estrecha + interlineado alto = menos fatiga |
| Barra sticky | Vuelves a la historia sin perder contexto del libro |
| Solo UI | El texto sigue saliendo de `chapter.content` del controlador |

### Para la exposición

“Al abrir un capítulo, Lumen prioriza la lectura: barra con el libro, tipografía cómoda y vuelta clara a la lista de capítulos.”

### Archivos

1. `app/views/reader/chapter.php`  
2. CSS `.reader-chapter*` en `app.css`  

### Práctica

1. Abre un capítulo desde una historia.  
2. Prueba el enlace volver arriba y el botón del pie.

---

## Mejora 10d — Biblioteca (2026-07-23)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Misma rejilla que Inicio | Reutilizan `.book-grid` y `.story-card` → coherencia visual |
| Quitar sin romper el clic | El form de quitar está fuera del `<a>` (HTML válido) |
| Datos existentes | Sigue siendo `Library::booksForUser`; solo cambió la vista |

### Para la exposición

“La biblioteca muestra tus historias guardadas como portadas, igual que el Inicio, y puedes quitarlas sin salir del diseño.”

### Archivos

1. `app/views/reader/library.php`  
2. CSS `.library-*` en `app.css`  

### Práctica

1. Guarda una historia desde Descubrir o la ficha.  
2. Ábrela desde la portada en Biblioteca.  
3. Prueba **Quitar** y comprueba el vacío si no queda ninguna.

---

## Mejora 10e — Página de la historia (2026-07-23)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Ficha de obra | La vista `book.php` es la “tienda” de la historia antes de leer |
| Portada sintética | Sin imagen real: color por `id * 47 % 360` (igual que Inicio/Biblioteca) |
| Empezar a leer | Enlace al **primer** capítulo de la lista que ya trae el controlador |
| Acciones | Biblioteca y seguir siguen siendo POST + CSRF; solo cambió el layout |
| Capítulos | Cada fila es un enlace a `/libros/{id}/capitulos/{capítulo}` |

### Para la exposición

“Al abrir una historia ves portada, sinopsis y botones claros; desde ahí guardas, sigues al autor o empiezas el primer capítulo.”

### Archivos

1. `app/views/reader/book.php`  
2. CSS `.story-hero*` y `.chapter-*` en `app.css`  

### Práctica

1. Desde Descubrir o Biblioteca abre una historia.  
2. Prueba **Empezar a leer**, un capítulo de la lista, guardar/quitar y seguir.  
3. Mira el vacío si una historia no tuviera capítulos.

---

## Mejora 10f — Perfil (2026-07-23)

### Qué deben entender

| Concepto | En una frase |
|----------|----------------|
| Perfil propio vs ajeno | `/perfil` = el tuyo (editas); `/u/usuario` = otro (puedes seguir) |
| Stats | Seguidores / siguiendo / historias salen de Follows + libros publicados |
| Popup de guardado | Tras POST exitoso hay flash; en Perfil se muestra como modal, no solo banner |
| Misma rejilla | Las obras del perfil reutilizan `.book-grid` / `.story-card` |

### Para la exposición

“En Perfil ves quién eres (avatar, bio, stats), editas tu nombre y biografía, y al guardar aparece un mensaje claro de confirmación.”

### Archivos

1. `app/views/reader/profile.php`  
2. CSS `.profile-*` / `.app-popup*` en `app.css`  
3. Flash en `ReaderController::updateProfile`  

### Práctica

1. Abre **Perfil**, cambia el nombre o la bio y guarda.  
2. Confirma el popup y que el sidebar muestre el nombre nuevo.  
3. Abre el perfil de un escritor desde Descubrir (`/u/...`) y prueba Seguir.

---

## Antes de la exposición (checklist vivo)

Marcar cuando corresponda (se refinará al final):

- [ ] Ambos pueden explicar MVC con el mapa de carpetas  
- [ ] Ambos instalaron el proyecto en XAMPP al menos una vez  
- [ ] Ambos saben registrar/iniciar/cerrar sesión  
- [ ] Ambos probaron Descubrir, Biblioteca y seguir a un autor  
- [ ] Ambos probaron el tema claro/oscuro y la barra de búsqueda  
- [ ] Ambos probaron la landing (carrusel + modal + footer) sin sesión  
- [ ] Ambos probaron login/register con el nuevo diseño y tema claro/oscuro  
- [ ] Ambos probaron validaciones (correo dominio, contraseña, usuario, ojito)  
- [ ] Ambos probaron el Inicio logueado (portadas + siguiendo)  
- [ ] Ambos probaron Descubrir (catálogo B + sección Escritores → perfil)  
- [ ] Ambos probaron leer un capítulo (vista inmersiva + volver a la historia)  
- [ ] Ambos probaron Biblioteca (rejilla de portadas + Quitar + vacío)  
- [ ] Ambos probaron la ficha de historia (portada + Empezar a leer + capítulos)  
- [ ] Ambos probaron Perfil (editar + popup de guardado + perfil ajeno)  
- [ ] Ambos pueden explicar qué es el middleware de roles y los niveles 1/2/3  
- [ ] Ambos probaron aprobar una solicitud de escritor en Admin  
- [ ] Ambos probaron el área Escribir (crear historia + capítulo)  
- [ ] Ambos saben enviar una solicitud de escritor (lector)  
- [ ] Ambos saben el flujo de roles (lector → solicitud → admin aprueba → escritor)  
- [ ] Ella hizo una demo de 5–10 min sin leer el código en vivo  
- [x] Existe `docs/entrega/` con el paso a paso limpio

Más contexto: [RECOMENDACIONES.md](RECOMENDACIONES.md) · puntos Git: [GIT-PUNTOS-DE-GUARDADO.md](GIT-PUNTOS-DE-GUARDADO.md).
