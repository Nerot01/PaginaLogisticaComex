# Guía de Despliegue en DonWeb

Sigue estos pasos para poner en marcha tu sitio web con base de datos y panel de administración.

## 1. Crear la Base de Datos en DonWeb
1. Ingresa a tu panel de control de DonWeb (Ferozo o cPanel).
2. Busca la sección **Base de Datos** o **MySQL**.
3. Crea una nueva base de datos (ya la tienes: `a0011267_baselog`).
4. Asegúrate que el usuario `a0011267_baselog` tenga permisos totales sobre esa base de datos.

## 2. Configurar la Conexión
Ya hemos configurado el archivo `backend/config.php` con tus datos. No necesitas hacer nada aquí si los datos `rirola80TO` son correctos.

## 3. Subir Archivos
1. Sube **toda** la carpeta del proyecto a la carpeta `public_html` (o `www`) de tu hosting usando FTP (FileZilla) o el Administrador de Archivos de DonWeb.
   - **Nota:** El archivo `backend/config.php` NO se subió a GitHub por seguridad. **Debes subirlo manualmente** o crearlo en el servidor con los datos de conexión.

## 4. Inicializar las Tablas (Base de Datos)
Tienes dos opciones:

### Opción A: Automática (Recomendada)
1. Una vez subidos los archivos, abre tu navegador y visita:
   `http://tudominio.com/backend/create_admin.php`
2. Deberías ver un mensaje diciendo "Usuario administrador creado exitosamente".
   - Esto creará las tablas y el usuario admin.
3. **IMPORTANTE:** Borra el archivo `backend/create_admin.php` del servidor después de usarlo.

### Opción B: Manual (phpMyAdmin)
1. Entra a **phpMyAdmin** desde tu panel de DonWeb.
2. Selecciona tu base de datos `a0011267_baselog` a la izquierda.
3. Ve a la pestaña **Importar**.
4. Selecciona el archivo `database/schema.sql` que está en tu proyecto.
5. Dale a **Continuar**.
6. Luego ve a la pestaña **SQL** y ejecuta esto para crear el usuario admin:
   ```sql
   INSERT INTO admin_users (username, password_hash) VALUES ('admin', '$2y$10$TU_HASH_GENERADO_AQUI...');
   ```
   *(Es mucho más fácil usar la Opción A porque ya genera la contraseña encriptada correctamente).*

## 5. Verificar
Entra a `http://tudominio.com/admin/login.html` y prueba entrar con:
- Usuario: `admin`
- Contraseña: `comex#2780`
