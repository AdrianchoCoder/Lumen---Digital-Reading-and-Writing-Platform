# Entrega de Lumen (para ti y tu prima)

Guía corta para instalar y presentar el proyecto cuando el desarrollo ya está en módulos 1–9.

## Para quien empaqueta (tú)

1. Asegúrate de que el código esté en GitHub al día (`git push`).
2. Opcional: zip de la carpeta del proyecto **sin** `.git` si piden archivo local.
3. Incluye o apunta a:
   - `database/lumen.sql`
   - `config/config.example.php`
   - esta carpeta `docs/entrega/`
   - `docs/desarrollo/ESTUDIAR.md` (para estudiar/explicar)

## Para quien instala (tu prima)

### Requisitos

- XAMPP (Apache + MySQL)
- Navegador

### Pasos

1. Copia el proyecto a `C:\xampp\htdocs\<lo-que-quieras>` (cualquier nombre de carpeta sirve) **o** crea un enlace (junction) como en el desarrollo.
2. Arranca **Apache** y **MySQL** en XAMPP.
3. Abre phpMyAdmin → Importar → `database/lumen.sql`.
4. Copia `config/config.example.php` a `config/config.php` si hace falta. Con `'url' => ''` (valor por defecto) la app detecta sola el dominio y la carpeta desde la petición, así que **no hace falta editar nada** aunque cambies el nombre de la carpeta.
5. Abre: `http://localhost/<nombre-de-tu-carpeta>/public`

### Cuentas demo

| Rol | Email | Contraseña |
|-----|-------|------------|
| Admin | `admin@lumen.local` | `Admin123!` |
| Escritor | `escritor@lumen.local` | `Escritor123!` |
| Lector | Registra uno nuevo | (la que elijas) |

### Guion de demo (5–10 min)

1. Portada → registro lector  
2. Descubrir → guardar en biblioteca → seguir autor  
3. Solicitar ser escritor  
4. Login admin → aprobar solicitud  
5. Re-login del usuario → Escribir → nueva historia + capítulo publicado  
6. Toggle tema claro/oscuro  

### Estudiar antes de exponer

Usa `docs/desarrollo/ESTUDIAR.md` módulo por módulo.
