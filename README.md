## Clonar repositorio

```bash
git clone https://github.com/aljosta/basic-store.git
```

## Cargar dependencias al proyecto

Dentro del proyecto clonado ejecutar el siguiente comando.

```bash
composer install
```

## Crear archivo .env

Lo podemas hacer copiando el .env.example y luego modificarlo.

```bash
copy .env.example .env
```

## Crear base de datos

Se debe tener una base de datos creada para configurar los datos de conexión y después hacer la migración.

## Generar llave para el proyecto

```bash
php artisan key:generate
```

## Migrar base de datos

Ejecutamos la migración con el siguiente comando.

```bash
php artisan migrate
```