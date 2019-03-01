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

**Archivo .sql (base de datos) - Importar desde phpmyadmin**
```shell
dominical/base de datos/dominical.sql
```

**Credencias de la base de datos se encuentran en el archivo `.env`**
```php
	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=dominical
	DB_USERNAME=root
	DB_PASSWORD=
```

**Dependencias**
```shell
composer install
php artisan key:generate
npm install
```
**Path URI Vuejs Editar**
```shell
	dominicals/resources/assets/js/components/Const.vue
		apiURL: 'http://localhost/dominical/public'
	command: npm run dev
```

**iniciar**
```shell
	http://127.0.0.1:8000
	http://localhost/dominical/public
```

## Colaborar

Cualquier aportación vía Pull-Request  :)