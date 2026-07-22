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

## Módulo 2 — Base de datos (pendiente)

_Se completará al cerrar el módulo 2: tablas, FKs, índices, cómo importar en phpMyAdmin, preguntas de repaso._

---

## Módulo 3 — Autenticación (pendiente)

_Se completará al cerrar el módulo 3._

---

## Módulo 4 — Lector (pendiente)

_Se completará al cerrar el módulo 4._

---

## Módulo 5 — Solicitud de escritor (pendiente)

_Se completará al cerrar el módulo 5._

---

## Módulo 6 — Escritor (pendiente)

_Se completará al cerrar el módulo 6._

---

## Módulo 7 — Administrador (pendiente)

_Se completará al cerrar el módulo 7._

---

## Módulo 8 — Middleware de roles (pendiente)

_Se completará al cerrar el módulo 8._

---

## Módulo 9 — Diseño visual (pendiente)

_Se completará al cerrar el módulo 9._

---

## Antes de la exposición (checklist vivo)

Marcar cuando corresponda (se refinará al final):

- [ ] Ambos pueden explicar MVC con el mapa de carpetas  
- [ ] Ambos instalaron el proyecto en XAMPP al menos una vez  
- [ ] Ambos saben el flujo de roles (lector → escritor → admin)  
- [ ] Ella hizo una demo de 5–10 min sin leer el código en vivo  
- [ ] Existe `docs/entrega/` con el paso a paso limpio (solo al final)

Más contexto: [RECOMENDACIONES.md](RECOMENDACIONES.md).
