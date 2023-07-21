# Sistema Contable con Laravel
Este sistema fue inspirado en ventaslite, sin embargo, incluye mejoras profundas

## Sistema de autenticación
- Descarga

**Bibliotecas**:
`composer require spatie/laravel-permission`

Se usaron dos clases de middlewares

`php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`

- DOMPDF
`composer require barryvdh/laravel-dompdf`

- Laravel Excel
`composer require maatwebsite/excel && php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config`

`php artisan optimize:clear`
`php artisan config:clear`
- Migraciones
`php artisan migrate`

**Plugins**
- flatpickr (se usó para el tema de caledarios en el front-end)


Referencia: https://spatie.be/docs/laravel-permission/v5/installation-laravel

## Imágenes

Ejemplo POS:

![Sistema1](https://github.com/perezgarridogilb/Sistema-Contable-con-Laravel/assets/56992179/11518f12-5b13-46d8-9a2b-6ba76b747384)

Ejemplo productos:

![Sisema1 1](https://github.com/perezgarridogilb/Sistema-Contable-con-Laravel/assets/56992179/92309196-6762-4e5b-889f-3ec4b2a2a79d)

## Primer diseño de la Base de Datos (MySQL)

![Base de Datos 1](https://github.com/perezgarridogilb/Backend-projects/assets/56992179/39960901-0bd4-41e4-9999-b434cf799736)
