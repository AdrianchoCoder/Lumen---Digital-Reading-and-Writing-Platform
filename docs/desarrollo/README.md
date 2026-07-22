# Seguimiento del desarrollo — Lumen

Documentación viva del proyecto de **Ingeniería de Software** (colegio).  
Sirve para **quien desarrolla** y para **quien presenta/estudia** el código (tú y tu prima).

## Para qué existe esta carpeta

| Objetivo | Cómo se cubre |
|----------|----------------|
| Entender el software módulo a módulo | [ESTUDIAR.md](ESTUDIAR.md) + [CHANGELOG.md](CHANGELOG.md) |
| Retomar el chat en Cursor | [PROMPT-CONTINUIDAD.md](PROMPT-CONTINUIDAD.md) |
| No perder avances / volver atrás | [GIT-PUNTOS-DE-GUARDADO.md](GIT-PUNTOS-DE-GUARDADO.md) |
| Recordar acuerdos y buenas prácticas | [RECOMENDACIONES.md](RECOMENDACIONES.md) |
| Entrega limpia al final (aún no) | Se creará `docs/entrega/` cerca del cierre |

## Archivos (actualizar TODOS en cada módulo)

| Archivo | Qué debe ganar en cada módulo |
|---------|-------------------------------|
| [README.md](README.md) | Tabla de estado + resumen |
| [CHANGELOG.md](CHANGELOG.md) | Implementación, decisiones, cómo probar, hash |
| [ESTUDIAR.md](ESTUDIAR.md) | Conceptos, archivos, preguntas, práctica |
| [PROMPT-CONTINUIDAD.md](PROMPT-CONTINUIDAD.md) | Estado + siguiente tarea |
| [RECOMENDACIONES.md](RECOMENDACIONES.md) | Notas/acuerdos del módulo |
| [GIT-PUNTOS-DE-GUARDADO.md](GIT-PUNTOS-DE-GUARDADO.md) | Tabla de commits |

## Estado del software

| Módulo | Descripción | Estado | Commit |
|--------|-------------|--------|--------|
| 1 | Estructura base MVC | Completado | `fb20bbc` |
| 2 | Script SQL `lumen.sql` | Completado | `4cf2488` |
| 3 | Autenticación | Completado | `02cc863` |
| 4 | Módulo Lector | Completado | `b7beee9` |
| 5 | Solicitud de escritor | Completado | `488e54c` |
| 6 | Módulo Escritor | Completado | `99dc2b9` |
| 7 | Módulo Administrador | Pendiente | — |
| 8 | Middleware de roles | Pendiente | — |
| 9 | Diseño visual completo | Pendiente | — |

## Resumen hasta el módulo 6

- URL: `http://localhost/lumen/public`
- Lector: Inicio, Descubrir, Biblioteca, Perfil, follows, solicitud escritor
- Escritor/Admin: **Escribir**, Mis libros, Nueva historia, Capítulos, Comunidades, Estadísticas
- Restricción temporal: `requireMinRole('escritor')` (middleware formal = módulo 8)
- Aprobar solicitudes y subir rol = módulo 7

## Ritual al cerrar cada módulo

1. CHANGELOG · 2. README · 3. ESTUDIAR · 4. PROMPT · 5. RECOMENDACIONES · 6. GIT · 7. commit + push

## Entrega final

`docs/entrega/` solo cerca del cierre. Ver [RECOMENDACIONES.md](RECOMENDACIONES.md).
