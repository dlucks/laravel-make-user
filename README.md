# Laravel MakeUser (Laravel 5 Package)

This is a simple Laravel package to create users by Artisan command.

## Installation

Install package via composer:

```
composer require dlucks/laravel-make-user
```

Register service provider in `config/app.php` of your project:

```php
'providers' => [

    // ...
    
    MakeUser\Providers\MakeUserServiceProvider::class,
],
```

Copy configurations and translations into project:

```
php artisan vendor:publish --tag=make_user
```

## Configuration

After publishing the vendor files there is a new configuration file 
`config/make_user.php` in your project. Within this file
you can set a couple of configurations:

| Parameter | Description |
| ------------- | ------------- |
| `user_class` | Class name of the user model (default `'App\User'`). |
| `role_class`  | Class name of the role model (default `'App\Role'`). |
| `user_validation_rules` | Array of validation rules to use for user creation. |
| `user_roles_relation_method` | Name of the method in user model to access the `BelongsToMany` relation to users roles (default `roles`). |
| `hash_password` | Flag to indicate if to hash the given password before saving (default `true`). |

## Usage

To create a new user execute the `make:user` command and set an
email address as a parameter:

```
php artisan make:user lucks.daniel@googlemail.com
```

During the command execution you will be asked for a password
and for roles to be attached to the created user.
