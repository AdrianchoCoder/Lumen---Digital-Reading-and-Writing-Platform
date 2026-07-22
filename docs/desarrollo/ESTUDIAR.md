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

1. Entra como lector e intenta `/admin` y `/escribir`.  
2. Entra como escritor e intenta `/admin`.  
3. Abre `web.php` y señala tres rutas con reglas distintas.

---

## Módulo 9 — Diseño visual (pendiente)

_Se completará al cerrar el módulo 9._

---

## Antes de la exposición (checklist vivo)

Marcar cuando corresponda (se refinará al final):

- [ ] Ambos pueden explicar MVC con el mapa de carpetas  
- [ ] Ambos instalaron el proyecto en XAMPP al menos una vez  
- [ ] Ambos saben registrar/iniciar/cerrar sesión  
- [ ] Ambos probaron Descubrir, Biblioteca y seguir a un autor  
- [ ] Ambos pueden explicar qué es el middleware de roles y los niveles 1/2/3  
- [ ] Ambos probaron aprobar una solicitud de escritor en Admin  
- [ ] Ambos probaron el área Escribir (crear historia + capítulo)  
- [ ] Ambos saben enviar una solicitud de escritor (lector)  
- [ ] Ambos saben el flujo de roles (lector → solicitud → admin aprueba → escritor)  
- [ ] Ella hizo una demo de 5–10 min sin leer el código en vivo  
- [ ] Existe `docs/entrega/` con el paso a paso limpio (solo al final)

Más contexto: [RECOMENDACIONES.md](RECOMENDACIONES.md) · puntos Git: [GIT-PUNTOS-DE-GUARDADO.md](GIT-PUNTOS-DE-GUARDADO.md).
