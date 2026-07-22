# Seguimiento del desarrollo — Lumen

Documentación viva del proyecto de **Ingeniería de Software** (colegio).  
Sirve para **quien desarrolla** y para **quien presenta/estudia** el código (tú y tu prima).

## Archivos (actualizar TODOS en cada módulo)

| Archivo | Uso |
|---------|-----|
| [README.md](README.md) | Estado + resumen |
| [CHANGELOG.md](CHANGELOG.md) | Detalle técnico por módulo |
| [ESTUDIAR.md](ESTUDIAR.md) | Guía de estudio compartida |
| [PROMPT-CONTINUIDAD.md](PROMPT-CONTINUIDAD.md) | Prompt para Cursor |
| [RECOMENDACIONES.md](RECOMENDACIONES.md) | Acuerdos y tips |
| [GIT-PUNTOS-DE-GUARDADO.md](GIT-PUNTOS-DE-GUARDADO.md) | Commits / restauración |

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
| 8 | Middleware de roles | Pendiente | — |
| 9 | Diseño visual completo | Pendiente | — |

## Resumen hasta el módulo 7

- URL: `http://localhost/lumen/public`
- Flujo completo de roles: lector → solicitud → **admin aprueba** → escritor
- Admin: `/admin` (solicitudes, usuarios, contenido)
- Gate: `requireMinRole('administrador')` (middleware formal = módulo 8)

## Ritual al cerrar cada módulo

1. CHANGELOG · 2. README · 3. ESTUDIAR · 4. PROMPT · 5. RECOMENDACIONES · 6. GIT · 7. commit + push

## Entrega final

`docs/entrega/` solo cerca del cierre. Ver [RECOMENDACIONES.md](RECOMENDACIONES.md).
