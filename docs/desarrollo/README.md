# Seguimiento del desarrollo — Lumen

Documentación viva del proyecto de **Ingeniería de Software** (colegio).

## Archivos (actualizar TODOS en cada módulo)

| Archivo | Uso |
|---------|-----|
| [README.md](README.md) | Estado + resumen |
| [CHANGELOG.md](CHANGELOG.md) | Detalle técnico |
| [ESTUDIAR.md](ESTUDIAR.md) | Estudio compartido |
| [PROMPT-CONTINUIDAD.md](PROMPT-CONTINUIDAD.md) | Prompt Cursor |
| [RECOMENDACIONES.md](RECOMENDACIONES.md) | Acuerdos |
| [GIT-PUNTOS-DE-GUARDADO.md](GIT-PUNTOS-DE-GUARDADO.md) | Commits |

## Estado del software

| Módulo | Descripción | Estado | Commit |
|--------|-------------|--------|--------|
| 1 | Estructura base MVC | Completado | `fb20bbc` |
| 2 | Script SQL `lumen.sql` | Completado | `4cf2488` |
| 3 | Autenticación | Completado | `02cc863` |
| 4 | Módulo Lector | Completado | `b7beee9` |
| 5 | Solicitud de escritor | Completado | `488e54c` |
| 6 | Módulo Escritor | Completado | `99dc2b9` |
| 7 | Módulo Administrador | Completado | `2597401` |
| 8 | Middleware de roles | Completado | _(tras push)_ |
| 9 | Diseño visual completo | Pendiente | — |

## Resumen hasta el módulo 8

- URL: `http://localhost/lumen/public`
- Roles jerárquicos: lector=1, escritor=2, administrador=3
- **RoleMiddleware** en rutas: `auth`, `guest`, `role:escritor`, `role:administrador`
- Defensa en profundidad: middleware en Router + `requireMinRole` / `requireAuth` en controladores
- Siguiente: módulo 9 (diseño visual)

## Ritual al cerrar cada módulo

1–6 docs de esta carpeta + commit + push

## Entrega final

`docs/entrega/` cerca del cierre. Ver [RECOMENDACIONES.md](RECOMENDACIONES.md).
