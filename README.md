# CRM Backend API

## Versiones y Requisitos
* **PHP**: >= 8.5
* **Composer**: Versión estable más reciente
* **Base de datos**: SQLite (por defecto) 

## Instalación y Configuración
1. Clonar el repositorio y acceder a la carpeta del proyecto.
2. Instalar las dependencias de Composer:
 
   composer install
Copiar el archivo de entorno y generar la clave de aplicación:

cp .env.example .env
php artisan key:generate

Configurar la base de datos SQLite en el entorno local:


touch database/database.sqlite
Asegurar que el archivo .env contenga:
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

Rama, Base de Datos y Ejecución
Rama de ejecución: feature/backend-crm (con Pull Request abierto hacia main).

Migraciones y carga de datos ficticios (Seeders):


php artisan migrate --seed
Ejecución de pruebas automatizadas:


php artisan test
Arranque del servidor de desarrollo:


php artisan serve
Funcionalidades, Pendientes y Limitaciones
Funcionalidades completadas: Endpoints RESTful para gestión de prospectos y seguimientos, paginación de 10 registros, búsqueda por nombre o teléfono, filtro por estado, validación estricta de teléfono único de 10 dígitos, transición automática de new a contacted al registrar el primer seguimiento, cierre de prospectos mediante PATCH, bloqueo de edición y nuevos seguimientos en prospectos cerrados con código 409, manejo de códigos HTTP consistentes (201, 422, 404, 409), transacciones de base de datos, seeder con 25 registros y pruebas en PHPUnit cubriendo duplicados de teléfono, primer seguimiento y rechazo en cerrados.

Pendientes: Ninguno dentro del alcance establecido.

## Limitaciones: Módulo acotado estrictamente a prospectos y seguimientos; sin autenticación ni eliminación de registros.

## Decisión Técnica Relevante
Se implementó el conteo de seguimientos directamente en las consultas Eloquent mediante subconsultas optimizadas (withCount) para evitar el problema de consultas N+1 por cada fila en el listado, garantizando rendimiento y limpieza en la respuesta JSON.

## Herramientas de IA utilizadas
Se utilizó asistencia de Inteligencia Artificial para la estructura inicial de validaciones de negocio en controladores y el diseño de los casos base para las pruebas automatizadas en PHPUnit.
