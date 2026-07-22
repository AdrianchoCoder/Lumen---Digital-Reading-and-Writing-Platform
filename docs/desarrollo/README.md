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
| Entrega limpia al final (aún no) | Se creará `docs/entrega/` cerca del cierre — ver recomendaciones |

## Archivos

| Archivo | Uso |
|---------|-----|
| [CHANGELOG.md](CHANGELOG.md) | Qué se implementó en cada módulo, decisiones y commits |
| [ESTUDIAR.md](ESTUDIAR.md) | Guía de estudio compartida (tú + ella): qué leer y qué deben poder explicar |
| [PROMPT-CONTINUIDAD.md](PROMPT-CONTINUIDAD.md) | Prompt para pegar en Cursor; se actualiza al cerrar cada módulo |
| [RECOMENDACIONES.md](RECOMENDACIONES.md) | Entrega, Git, cuándo documentar, cómo presentar en el colegio |
| [GIT-PUNTOS-DE-GUARDADO.md](GIT-PUNTOS-DE-GUARDADO.md) | Cómo usar commits como “partidas guardadas” |

## Estado del software

| Módulo | Descripción | Estado |
|--------|-------------|--------|
| 1 | Estructura base MVC + config + Database + Router + Controller | Completado |
| 2 | Script SQL `database/lumen.sql` | Completado |
| 3 | Autenticación (registro, login, logout, sesiones) | Completado |
| 4 | Módulo Lector | Completado |
| 5 | Solicitud para convertirse en Escritor | Pendiente |
| 6 | Módulo Escritor | Pendiente |
| 7 | Módulo Administrador | Pendiente |
| 8 | Middleware de roles | Pendiente |
| 9 | Integración del diseño visual completo | Pendiente |

## Ritual al cerrar cada módulo (obligatorio)

Cuando confirmemos que un módulo está bien, Cursor (o quien documente) debe:

1. Actualizar **CHANGELOG.md** (qué se hizo, decisiones, cómo probar, hash del commit)
2. Actualizar la **tabla de estado** de este README
3. Ampliar **ESTUDIAR.md** con lo nuevo que deben entender tú y ella
4. Actualizar **PROMPT-CONTINUIDAD.md** (estado + siguiente módulo + instrucción de seguir documentando)
5. Añadir notas nuevas en **RECOMENDACIONES.md** si surgió algún acuerdo
6. Hacer **commit + push** a GitHub (punto de guardado)

## Regla sobre la entrega final

**No** crear aún la guía completa de “pasarle el zip limpio a tu prima”.  
Eso se hace al **final** (o cuando el proyecto esté presentable). Hasta entonces, esta carpeta es el material de estudio y seguimiento.

Detalle en [RECOMENDACIONES.md](RECOMENDACIONES.md).
