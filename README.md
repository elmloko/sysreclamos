# USER SERVICE SYSTEM FOR THE BOLIVIAN POST OFFICE AGENCY "sysReclamos"

The User Service System for the Bolivian Postal Agency is a comprehensive platform designed to efficiently and centrally manage interactions between users and the postal service. This system allows citizens to make inquiries, file claims, complaints, suggestions and incidents related to postal services offered by the Bolivian Postal Agency.

Among its main functionalities, the system facilitates the registration of user requests, ensuring a timely and effective response from the agency.

In addition, the system allows internal management of the requests received, classifying them according to their nature (claims, suggestions, complaints, incidents or queries) and prioritizing them for resolution. In this way, personalized and prompt attention is guaranteed, improving user satisfaction and optimizing the internal processes of the Bolivian Postal Agency.

## LANGUAGES, FRAMEWORKS USED AND TOOLS 🛠️

* PHP 8.2.20
* LARAVEL 10
* LIVEWIRE
* COMPOSER
* MYSQL

  https://laravel-excel.com/                                    				maatwebsite/excel
  https://github.com/barryvdh/laravel-dompdf                    		barryvdh/laravel-dompdf
  https://github.com/awais-vteams/laravel-crud-generator        	ibex/crud-generator
  https://github.com/jeroennoten/Laravel-AdminLTE               	jeroennoten/laravel-adminlte
  https://spatie.be/docs/laravel-permission/v5/introduction    	spatie/laravel-permission
  https://laravel-livewire.com/                             				livewire/livewire
  https://github.com/biscolab/laravel-recaptcha				biscolab/laravel-recaptcha
  https://jwt-auth.readthedocs.io/en/develop/					tymon/jwt-auth
  https://laravel.com/docs/11.x/pulse						laravel/pulse
  https://log-viewer.opcodes.io/							opcodesio/log-viewer
  https://docs.guzzlephp.org/en/stable/						guzzlehttp/guzzle
  https://github.com/anhskohbo/no-captcha					anhskohbo/no-captcha

## Installation

We clone the repository

```bash
git clone https://github.com/elmloko/sysreclamos.git
```

We install our dependencies with [XAMMP](https://www.apachefriends.org/es/download.html)

## DataBases

* We import the database to MySQL

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sysreclamos
DB_USERNAME=root
DB_PASSWORD=
```

* migrate and seed in database

## Credentials

| User  | Pass  |
| ----- | ----- |
| Admin | admin |

## Authors and acknowledgment

Developers of this software

* Marco Antonio Espinoza Rojas

## System installation

* Install Node dependencies:

```bash
npm install
```

* Install Composer dependencies:

```bash
composer install
```

* Copy the environment configuration file:

```bash
cp .env.example .env
```

* Generate the application key:

```bash
php artisan key:generate
```

## System configuration

* System cleanup and optimization:

```bash
php artisan optimize
```

* Generate jwt token:

```bash
php artisan jwt:secret
```

* Capturing Entries:

```bash
php artisan pulse:check
```

## License

[GNU](https://www.gnu.org/licenses/gpl-3.0.en.html)
