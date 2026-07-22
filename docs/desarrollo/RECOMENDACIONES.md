# Recomendaciones del proyecto — Lumen

Acuerdos y consejos acumulados durante el desarrollo.  
**Se va ampliando** al cerrar cada módulo o cuando surja una decisión importante.

Última actualización de este archivo: **módulo 2** (2026-07-22).

---

## 1. Para quién es el proyecto

- Proyecto de **colegio**, carrera de **Ingeniería de Software**.
- Tú construyes y aprendes con Cursor; tu **prima** debe poder **instalarlo, presentarlo y entender el código**.
- Meta: que ambos estudien las mismas explicaciones en `docs/desarrollo/`.

---

## 2. Cómo trabajar con Cursor (método incremental)

1. Un **módulo a la vez** (orden 1 → 9).
2. Al terminar: ver código, decisiones breves, **esperar confirmación** antes del siguiente.
3. No asumir requisitos no pedidos; preguntar si algo no está claro.
4. Tras cada módulo aprobado: actualizar esta carpeta (`CHANGELOG`, `ESTUDIAR`, `PROMPT-CONTINUIDAD`, este archivo si aplica) + **commit + push**.

---

## 3. Git = puntos de guardado

- Cada commit (mejor con push a GitHub) es una “partida guardada”.
- Si algo sale mal, se puede volver a un commit anterior o crear una rama desde ese punto.
- Guía práctica: [GIT-PUNTOS-DE-GUARDADO.md](GIT-PUNTOS-DE-GUARDADO.md).
- Punto de guardado del módulo 1: commit `fb20bbc` (rama `main`).
- URL local recomendada con junction: `http://localhost/lumen/public` (enlace `C:\xampp\htdocs\lumen` → carpeta del repo).

---

## 4. Documentación: qué hacer YA vs al FINAL

### Hacer desde ahora (esta carpeta)

- Changelog por módulo  
- Guía de estudio (`ESTUDIAR.md`)  
- Prompt de continuidad  
- Recomendaciones (este archivo)  

Así el material de estudio **crece con el software** y no se pierde el contexto.

### Esperar a cerca del final — entrega limpia

**No** escribir aún la guía definitiva de “empaquetar y entregarle el proyecto a tu prima”.

Motivo: esa guía habla de zip final, SQL definitivo, usuarios demo, pantallas reales y guion de exposición. Si se escribe temprano, **queda obsoleta** en cada módulo.

| Momento | Qué documentar |
|---------|----------------|
| Ahora → casi al final | Seguimiento y estudio en `docs/desarrollo/` |
| Cuando módulos 1–8 estén estables | Borrador de instalación XAMPP + demo |
| Al cerrar módulo 9 / proyecto presentable | Carpeta `docs/entrega/` con guía limpia |

### Qué incluirá `docs/entrega/` (futuro)

Cuando toque crearla:

1. Paso a paso para **ti** (empaquetar, limpiar, pasar el proyecto)
2. Paso a paso para **ella** (XAMPP, importar SQL, config, abrir la app)
3. Cuentas demo (lector / escritor / admin)
4. Guion corto de presentación / demo
5. Checklist: “¿puedo explicar el MVC y los roles?”
6. Mapa del código alineado con el software **ya terminado**

---

## 5. Cómo entregar el software al final (visión general)

Cuando el desarrollo esté mayormente listo:

1. **Entregable limpio:** carpeta o `.zip` + `lumen.sql` + `config.example.php`
2. **Guía de 10 minutos** de instalación en XAMPP
3. **Transferencia:** repo a su GitHub o zip; quitar datos personales innecesarios
4. **Que ella lo corra sola** una vez en su PC
5. **Ensayo** de presentación de 5–10 minutos

Detalle fino se escribirá en `docs/entrega/` en su momento.

---

## 6. Presentación en el colegio (importante)

- Ella debe **entender** arquitectura MVC, roles, flujo de pantallas y poder responder preguntas.
- Presentar trabajo ajeno como 100 % propio sin haberlo comprendido (ni declarar colaboración si el curso lo exige) es riesgoso académicamente.
- Enfoque sano: ella presenta el producto **habiéndolo estudiado** con `ESTUDIAR.md` y pudiendo explicar el código; si el colegio pide declarar tutoría/colaboración/herramientas, hacerlo según sus reglas.

---

## 7. Stack y decisiones de diseño ya fijadas

- PHP OO + MVC puro (sin Laravel)
- MySQL / XAMPP / phpMyAdmin
- Frontend vanilla (HTML/CSS/JS)
- Roles jerárquicos en un solo campo `users.role`: lector=1, escritor=2, administrador=3
- Fuera de alcance por ahora: **Logros** y **Mensajes**
- Seguridad: `password_hash`/`password_verify`, PDO preparado, sesiones, XSS, CSRF en formularios sensibles
- PK recomendada para el SQL: `INT UNSIGNED AUTO_INCREMENT` (confirmar al hacer módulo 2)

---

## 8. Cómo probar el módulo 1–2 (recordatorio)

1. Junction: `C:\xampp\htdocs\lumen` → repo en Documents/GitHub  
2. `config.php` → `'url' => 'http://localhost/lumen/public'`  
3. XAMPP: Apache + MySQL  
4. Importar `database/lumen.sql` en phpMyAdmin (si aún no está)  
5. Abrir `http://localhost/lumen/public` — debería indicar conexión PDO correcta  

Explicación de carpetas y BD: [ESTUDIAR.md](ESTUDIAR.md).

---

## 9. Opción B de instalación: enlace en htdocs (módulo 1–2)

No hace falta copiar el proyecto a `htdocs`. En Windows se creó una unión:

```bat
mklink /J C:\xampp\htdocs\lumen "C:\Users\USUARIO\OneDrive\Documents\GitHub\Lumen---Digital-Reading-and-Writing-Platform"
```

Quitar el enlace (no borra el repo): `rmdir C:\xampp\htdocs\lumen`

---

## Plantilla: nuevas recomendaciones

Al añadir algo nuevo, usar este formato al final del archivo:

```markdown
## N. Título breve (módulo X — AAAA-MM-DD)

Texto de la recomendación o acuerdo.
```
