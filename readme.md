<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"><img src="https://vuejs.org/images/logo.png" width="197px" height="64px"></p>

## Link publico del proyecto (URL)
https://dominical.herokuapp.com/

**Usuario previamente registrado / Rol Administrador**
```shell
usuario: admin@hotmail.com
password: Ss123-*
```
## Requerimientos

- PHP >= 7.1.3
- MySQL
- Git
- Composer
- npm

## Instalación

**Git**
```shell
git clone https://github.com/rafaelchirel/dominical.git
```

- Dentro del proyecto (en la raiz), crear un archivo llamado `.env`
- Luego copiar todo el contenido de `.env.example` y pegarlo en el nuevo archivo creado `.env`
- Desde phpMyAdmin, importar base de datos (db), se encuentra en la carpeta BDD del proyecto.
- Asociar las credencias de la base de datos en el archivo `.env`
```php
	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=dominical
	DB_USERNAME=root
	DB_PASSWORD=
```

**Composer**
```shell
npm install
composer install
php artisan key:generate
php artisan serve
```

## Colaborar

Cualquier aportación vía Pull-Request  :)