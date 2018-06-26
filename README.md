# Laravel API Boilerplate
A boilerplate to develop secured and conventional API on top of Laravel 5.6.

Dependencies:
* PHP ~7.1.0
* [Laravel 5.6](https://laravel.com/docs/5.6/)
* [JWT Auth 1.0.*](https://github.com/tymondesigns/jwt-auth) Package
* [Dingo Api](https://github.com/dingo/api) Package

## Installation
#### 1. Clone the project
```bash
git clone https://github.com/mystroken/laravel-api-boilerplate.git destination_folder
```
#### 2. Install project dependencies
```bash
composer install
```
#### 3. Generate API secret keys
```
php artisan key:generate
```
```
php artisan jwt:secret
```

```config/api.php```

```config/jwt.php```

## Usage
### Introduction
After installing the 
### Creating a new endpoint
* Write a Repository
* Write a Request (Validations)
