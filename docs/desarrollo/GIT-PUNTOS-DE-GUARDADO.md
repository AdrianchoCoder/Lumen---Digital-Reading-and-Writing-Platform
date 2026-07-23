# Git: puntos de guardado (cómo volver atrás)

Sí: cada **commit** (y mejor aún si está en **GitHub con push**) es un punto de restauración. Puedes volver a ese estado si te arrepientes de cambios posteriores.

## Idea simple

```
commit A (módulo 1)  ← punto de guardado
    ↓
commit B (módulo 2)
    ↓
commit C (módulo 3)  ← estás aquí y algo salió mal
```

Puedes:

- **Mirar** cómo estaba el código en A
- **Deshacer** cambios locales sin borrar el historial
- **Crear una rama** desde A y seguir desde ahí
- En casos extremos, **resetear** la rama a A (con cuidado)

## Comandos útiles

### Ver el historial (tus puntos de guardado)

```bash
git log --oneline
```

Ejemplo de salida:

```
c3a91f2 docs: seguimiento de desarrollo
a1b2c3d feat: núcleo MVC base (módulo 1)
f6cb580 Initial commit
```

### Guardar el trabajo actual (lo normal al cerrar un módulo)

```bash
git add .
git commit -m "mensaje claro del módulo"
git push
```

El `push` sube el punto de guardado a GitHub. Si se rompe el PC, el commit sigue en la nube.

### Volver temporalmente a un commit (solo mirar, sin romper nada)

```bash
git switch --detach a1b2c3d
```

Para regresar a la punta de `main`:

```bash
git switch main
```

### Empezar de nuevo desde un punto (recomendado: rama nueva)

Si el módulo 3 te falló y quieres continuar desde el módulo 1 sin perder el historial:

```bash
git switch -c reinicio-desde-modulo-1 a1b2c3d
```

Trabajas en la rama `reinicio-desde-modulo-1`. `main` y los otros commits siguen existiendo.

### Descartar cambios locales SIN commit (aún no guardados)

Si editaste archivos y quieres volver al último commit:

```bash
git restore .
git clean -fd
```

`git clean -fd` borra archivos nuevos no rastreados: úsalo solo si estás seguro.

### Deshacer commits ya hechos en local (aún no pusheados o con cuidado)

- Soft (conserva los archivos modificados):

```bash
git reset --soft HEAD~1
```

- Hard (vuelve exactamente al commit anterior; **borra** cambios no commitados):

```bash
git reset --hard a1b2c3d
```

Si ese commit **ya estaba en GitHub** y haces reset hard + push, hace falta `push --force`, que es peligroso en `main`. Mejor avisa antes y usa una rama.

## Recomendación para Lumen

1. Al terminar cada módulo: **commit + push**
2. Anota el hash en `CHANGELOG.md` **y** en la tabla de abajo
3. Actualiza **todos** los archivos de `docs/desarrollo/` (acuerdo del proyecto)
4. Si algo sale mal: crea una **rama desde el commit bueno**, no borres `main` a la ligera

Así siempre tienes un “guardar partida” en GitHub.

## Tabla de puntos de guardado (actualizar en cada módulo)

| Módulo | Descripción corta | Commit | Rama |
|--------|-------------------|--------|------|
| 0 | Initial commit del repo | `f6cb580` | `main` |
| 1 | Núcleo MVC | `fb20bbc` | `main` |
| 2 | SQL `lumen.sql` + URL local | `4cf2488` | `main` |
| 3 | Autenticación | `02cc863` | `main` |
| 4 | Módulo Lector | `b7beee9` | `main` |
| 5 | Solicitud de escritor | `488e54c` | `main` |
| 6 | Escritor | `99dc2b9` | `main` |
| 7 | Administrador | `2597401` | `main` |
| 8 | Middleware de roles | `990629c` | `main` |
| 9 | Diseño visual | `ccf6ceb` | `main` |
| 9+ | Landing page pública | `480779d` | `main` |
| 9+b | Logo + fondo + hovers landing | `2374778` | `main` |
| 9+c | Pulido marca / hover claro / carrusel | `e996bd4` | `main` |
| 9+d | Auth login/register + marca separada | `07430cb` | `main` |
| 9+e | Validaciones login/register + ojito | `4412bab` | `main` |
| 9+f | UX compacta formularios auth | `f5d54f2` | `main` |
| 9+g | Fix ojito contraseña (SVG assets) | `98517ff` | `main` |
| 9+h | Ojito Font Awesome dentro del campo | `c7cde0f` | `main` |
| 10a | Inicio logueado UI (rejilla + siguiendo) | `12d3664` | `main` |
| 10b | Descubrir catálogo B + logo sidebar | `044ea70` | `main` |
| 10c | Lectura de capítulo inmersiva (A) | *(rellenar tras commit)* | `main` |

Para volver al estado del módulo 5, por ejemplo:

```bash
git switch -c reinicio-desde-modulo-5 488e54c
```

