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

## Archivos (actualizar TODOS en cada módulo)

| Archivo | Qué debe ganar en cada módulo |
|---------|-------------------------------|
| [README.md](README.md) (este) | Tabla de estado + notas del ritual si cambian |
| [CHANGELOG.md](CHANGELOG.md) | Implementación, decisiones, cómo probar, hash commit |
| [ESTUDIAR.md](ESTUDIAR.md) | Conceptos, archivos a leer, preguntas, práctica |
| [PROMPT-CONTINUIDAD.md](PROMPT-CONTINUIDAD.md) | Estado actual + siguiente tarea + checklist de docs |
| [RECOMENDACIONES.md](RECOMENDACIONES.md) | Acuerdos nuevos del módulo (cuentas, flujos, instalación, etc.) |
| [GIT-PUNTOS-DE-GUARDADO.md](GIT-PUNTOS-DE-GUARDADO.md) | Tabla de commits/puntos de guardado por módulo |

**Regla acordada:** no basta con tocar solo `ESTUDIAR.md`. Al cerrar un módulo se actualiza **toda** esta carpeta y luego **commit + push**.

## Estado del software

| Módulo | Descripción | Estado | Commit |
|--------|-------------|--------|--------|
| 1 | Estructura base MVC + config + Database + Router + Controller | Completado | `fb20bbc` |
| 2 | Script SQL `database/lumen.sql` | Completado | `4cf2488` |
| 3 | Autenticación (registro, login, logout, sesiones) | Completado | `02cc863` |
| 4 | Módulo Lector | Completado | `b7beee9` |
| 5 | Solicitud para convertirse en Escritor | Completado | `488e54c` |
| 6 | Módulo Escritor | Pendiente | — |
| 7 | Módulo Administrador | Pendiente | — |
| 8 | Middleware de roles | Pendiente | — |
| 9 | Integración del diseño visual completo | Pendiente | — |

## Resumen rápido hasta el módulo 5

- App en `http://localhost/lumen/public` (junction `htdocs/lumen`)
- Roles: lector → puede pedir ser escritor; escritor/admin demo ya existen
- Lector: Inicio, Descubrir, Biblioteca, Perfil, follows, lectura
- Solicitud escritor: `/solicitar-escritor` (aprobación = módulo 7)

## Ritual al cerrar cada módulo (obligatorio — checklist)

Cuando un módulo quede bien, Cursor debe completar **todos** estos puntos:

1. [ ] **CHANGELOG.md** — qué se hizo, decisiones, cómo probar, hash
2. [ ] **README.md** — tabla de estado (+ commit y resumen si aplica)
3. [ ] **ESTUDIAR.md** — conceptos, archivos, preguntas, práctica, checklist exposición
4. [ ] **PROMPT-CONTINUIDAD.md** — estado + siguiente módulo + recordatorio de actualizar **todos** los docs
5. [ ] **RECOMENDACIONES.md** — al menos una nota del módulo (aunque sea corta)
6. [ ] **GIT-PUNTOS-DE-GUARDADO.md** — añadir el commit del módulo a la tabla
7. [ ] **commit + push** a GitHub

## Regla sobre la entrega final

**No** crear aún la guía completa de “pasarle el zip limpio a tu prima”.  
Eso se hace al **final** (o cuando el proyecto esté presentable). Hasta entonces, esta carpeta es el material de estudio y seguimiento.

Detalle en [RECOMENDACIONES.md](RECOMENDACIONES.md).
