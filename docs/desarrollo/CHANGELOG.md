# Changelog de desarrollo — Lumen

Registro incremental. El más reciente va arriba.

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
