# Minimum Requirement
 - PHP 7.4.x
 - Laravel 8.1.x or above

## Installation Guide

Enter to your webroot folder and run 
 - composer install
 - composer require apereo/phpcas:1.3.8

### Create new database

Create your database

### Environment Configuration
 - cp .env.example .env
 - php artisan key:generate
 - Edit .env file and change database configuration username, password and database name

## Artisan Migration
 -- Change your superadmin account to your user

 - php artisan migrate --seed

## Refresh Database
 - php artisan migrate:refresh --seed

## Dump autoload
Untuk load helper customization
 - composer dump-autoload
 
 # How to use UUID as primary key

 ### migration file

```php
 Schema::create('example', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('name');
    $table->timestamps();
});
```

### Default superadmin user

Username : admin@gmail.com
Password : admin@123

### model
```php
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
class Example extends Model
{
    use Uuid;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];
}
```

### reference 
https://kim-jangwook.medium.com/use-uuid-as-primary-key-of-laravel-eloquent-orm-82e3db36cb62

# SweetAlert
- https://realrashid.github.io/sweet-alert/install

# AdminLTE
- https://github.com/jeroennoten/Laravel-AdminLTE/wiki


# CODE

### create function 
```php
protected $baseView = '';

/**
 * Display a booking setup page.
 * 
 * @return Renderable
 */
public function functionname() {
    return $this->view([$this->baseView, 'viewfile'])->with('title', __('page.title'));
}
```

### Template when create new blade file
```php
@extends('adminlte::page')

@section('title', $title)

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>{{ $title }}</h1></div>
</div>
@stop

@section('content')
<div class="container-fluid"></div>
@endsection
```