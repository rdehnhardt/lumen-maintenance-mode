#Lumen maintenance mode

##How to install

```
composer require rdehnhardt/lumen-maintenance-mode
```

##How to configure
In bootstrap/app.php, add this instruction in providers

```
$app->register(
    Rdehnhardt\MaintenanceMode\Providers\MaintenanceModeServiceProvider::class
);
```

##Put the application into maintenance mode.

```
php artisan down
```

##Bring the application out of maintenance mode.

```
php artisan up
```