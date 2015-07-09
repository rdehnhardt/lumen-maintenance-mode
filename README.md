#Lumen maintenance mode

##How to install

```
composer require rdehnhardt/lumen-maintenance-mode
```

##How to configure
In bootstrap/app.php, add this instruction in providers

```
$app->register(Rdehnhardt\MaintenanceMode\Providers\MaintenanceModeServiceProvider::class);
```