# Seguimiento del desarrollo — Lumen

Esta carpeta documenta el avance del software **módulo a módulo**, para que puedas:

- Estudiar qué se hizo y por qué
- Retomar el trabajo en Cursor con un prompt listo
- Volver a un punto de guardado en Git si algo sale mal

## Cómo usar esta carpeta

| Archivo | Uso |
|---------|-----|
| [CHANGELOG.md](CHANGELOG.md) | Historial de lo implementado en cada módulo |
| [PROMPT-CONTINUIDAD.md](PROMPT-CONTINUIDAD.md) | Texto para pegar en Cursor y continuar desde el módulo siguiente |
| [GIT-PUNTOS-DE-GUARDADO.md](GIT-PUNTOS-DE-GUARDADO.md) | Cómo volver a un commit anterior (punto de restauración) |

## Estado actual

| Módulo | Descripción | Estado |
|--------|-------------|--------|
| 1 | Estructura base MVC + config + Database + Router + Controller | Completado |
| 2 | Script SQL `database/lumen.sql` | Pendiente |
| 3 | Autenticación (registro, login, logout, sesiones) | Pendiente |
| 4 | Módulo Lector | Pendiente |
| 5 | Solicitud para convertirse en Escritor | Pendiente |
| 6 | Módulo Escritor | Pendiente |
| 7 | Módulo Administrador | Pendiente |
| 8 | Middleware de roles | Pendiente |
| 9 | Integración del diseño visual completo | Pendiente |

## Convención

Al cerrar cada módulo:

1. Actualizar `CHANGELOG.md` con lo nuevo
2. Actualizar la tabla de estado de este README
3. Ajustar `PROMPT-CONTINUIDAD.md` al siguiente módulo
4. Hacer **commit + push** (punto de guardado en GitHub)
