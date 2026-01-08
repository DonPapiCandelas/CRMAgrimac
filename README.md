# CRM Agrimac

Sistema de gestión personalizado (CRM) para Agrimac. Este repositorio contiene el código fuente de la aplicación web.

## 📋 Descripción General
El sistema gestiona procesos internos de Agrimac, incluyendo clientes, inventarios y reportes. Está construido sobre un framework PHP personalizado siguiendo el patrón MVC (Modelo-Vista-Controlador).

## 📂 Estructura del Proyecto

El proyecto sigue una estructura organizada para separar la lógica de negocio, la presentación y los datos:

- **`root/`**
  - `index.php`: Punto de entrada único de la aplicación. Gestiona el enrutamiento.
  - `.gitignore`: Configuración para excluir archivos temporales y pesados.

- **`includes/`**: Núcleo de la lógica de la aplicación via **MVC**:
  - `controllers/`: Lógica de control (Clases que empiezan con `c`).
  - `models/`: Modelos de datos y reglas de negocio (Clases que empiezan con `m`).
  - `views/`: Vistas y plantillas de la interfaz.
  - `routes/`: Definiciones de rutas personalizadas.
  - `database/` & `database-sql/`: Clases para la abstracción y conexión a la base de datos.
  - `init.php`: **Archivo crítico**. Configuración global, conexión a BD (DB Connection) y autocargador de clases.

- **`views/`**: Archivos de plantillas (`.tpl`) que definen la interfaz gráfica de usuario.

- **`assets/`**: Recursos estáticos públicos (Imágenes, CSS, JS).

## ⚠️ Archivos Excluidos (Git Ignore)
Para mantener el repositorio ligero y eficiente, se han excluido las siguientes carpetas y archivos locales:
- ❌ **`uploads/`**: Contiene archivos subidos por los usuarios (aprox. 4GB). **Debe respaldarse manualmente**.
- ❌ **`backup/`**: Dumps de base de datos locales (.sql).
- ❌ **Logs**: Archivos `.log` generados por el sistema.

## 🛠️ Instalación y Despliegue

### Requisitos Previos
- Servidor Web (Apache recomendado con `mod_rewrite`).
- PHP 7.4 o superior.
- MySQL / MariaDB.

### Pasos
1. **Clonar el repositorio** en su carpeta pública (`htdocs` o `www`).
2. **Restaurar Base de Datos**: 
   - Importe el archivo `schema_structure.sql` incluido en la raíz para crear la estructura de tablas y procedimientos.
   - Si tiene un backup de datos completo, impórtelo después.
3. **Configuración**:
   - Abra el archivo `includes/init.php`.
   - Configure las credenciales de la base de datos en el array `$config`:
     ```php
     $config = [
         'host'      => 'localhost',
         'database'  => 'agrimac',
         'username'  => 'SU_USUARIO',
         'password'  => 'SU_CONTRASEÑA',
         // ...
     ];
     ```

## 🔑 Puntos Clave para Desarrolladores
- **Enrutamiento**: El sistema usa `spl_autoload_register` en `index.php` para cargar clases automáticamente según su prefijo (`c` para controladores, `m` para modelos).
- **Seguridad**: Las sesiones y permisos se gestionan en `cUser`.
- **Base de Datos**: Se utiliza una capa de abstracción en `includes/database/` usando PDO.
