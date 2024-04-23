# Prueba técnica - backend

## Requisitos Previos

-   PHP 7.4
-   Composer instalado
-   MySQL, PostgreSQL u otro sistema de gestión de bases de datos
-   Laragon instalado y configurado

## Instalación

1. Clona este repositorio: `git clone https://github.com/devPabloCH/prueba-backend.git`
2. Navega al directorio del proyecto: `cd nombre-del-proyecto`
3. Instala las dependencias de Composer: `composer install`
4. Copia el archivo `.env.example` a `.env` y configura las variables de entorno, incluyendo la configuración de la base de datos
5. Genera una nueva clave de aplicación: `php artisan key:generate`
6. Ejecuta las migraciones de la base de datos: `php artisan migrate`
7. Instala y configura Laravel Passport: `php artisan passport:install`

## Uso

### Con Laragon

1. Abre Laragon
2. Haz clic en "Start All" para iniciar los servicios (Apache, MySQL, etc.)
3. Abre el navegador y ve a `http://localhost` o `http://nombre-del-proyecto.test` (si has configurado un nombre de host virtual en Laragon)

### Sin Laragon

1. Inicia el servidor de desarrollo: `php artisan serve`
2. Abre tu navegador y ve a `http://localhost:8000`
