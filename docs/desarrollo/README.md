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
| 8 | Middleware de roles | Completado | `990629c` |
| 9 | Diseño visual completo | Completado | `ccf6ceb` |
| 9+ | Landing page pública (estilo Wattpad) | Completado | `480779d` |
| 9+b | Logo + fondo landing + hovers | Completado | `2374778` |
| 9+c | Pulido marca / hover claro / carrusel | Completado | `e996bd4` |
| 9+d | Auth login/register + marca separada | Completado | `07430cb` |
| 9+e | Validaciones login/register + ojito | Completado | `4412bab` |

## Plan de módulos: cerrado

Los **9 módulos** del plan inicial están completos.  
A partir de aquí: mejoras de frontend, bugs, o lo que pidan en el colegio.

### Última mejora (9+)

Landing + auth con diseño unificado, y validaciones de seguridad en login/register (cliente + servidor, hints, ojito). **Sin cambiar** la estructura MVC.

Guía de entrega: [../entrega/README.md](../entrega/README.md)

## Ritual (sigue aplicando a cambios grandes)

1–6 docs + commit + push cuando cierres un bloque de trabajo.

URL local: `http://localhost/lumen/public`
