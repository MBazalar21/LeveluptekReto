
# Leveluptek Reto

El objetivo de este reto es construir una API REST en Laravel que implemente autenticación segura, una estructura modular y el consumo de una API externa.




## Migrar Base de Datos y Seed

Al ejecutar el siguiente comando se migrara la base de datos segun esta fuese previamente creada : `lut_database`.

```bash
  php artisan migrate:fresh --seed
```

### Ejecución del proyecto



```bash
  php artisan serve
```
## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

Para la ejecucion de este proyecto, es necesario compartir las variables de entorno .env para el uso de ls bd.

`DB_DATABASE`
`DB_USERNAME`
`DB_PASSWORD`


## Seguridad

La seguridad se esta realizando en base a tokens pero usando librerias laravel , el uso de sanctum como api, nos brindo seguridad en apis requeridas. Se uso para la autenticacion de roles y permisos usando Spatie.



## Distribucion de Carpetas

Usando MVC de laravel , se estructuro las carpetas por dominio para facilitar la escalabilidad y mantenimiento del código.

```bash
    ├───app
    │   ├───Exceptions
    │   ├───Http
    │   │   ├───Controllers
    │   │   │   ├───Auth
    │   │   │   └───Swapi
    │   │   └───Middleware
    │   ├───Models
    │   ├───Providers
    │   └───Services
```
    
