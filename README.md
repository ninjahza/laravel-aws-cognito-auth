# Laravel AWS Cognito Auth

A simple authentication package for Laravel 5 for authenticating users in Amazon Cognito User Pools.

This is package works with Laravel's native authentication system and allows the authentication of users that are already registered in Amazon Cognito User Pools. It does not provide functionality for user management, i.e., registering user's into User Pools, password resets, etc.


### Contents

- [Installation and Setup](#installation-and-setup)
    - [Install](#install)
    - [Configure](#configure)
    - [Users Table](#users-table)
- [Usage](#usage)
    - [Authenticating](#authenticating)
    - [Handling Failed Authentication](#handling-failed-authentication)
        - [Methods](#methods)
            - [No Error Handling](#no-error-handling)
            - [Throw Exception](#throw-exception)
            - [Return Attempt Instance](#return-attempt-instance)
            - [Using a Closure](#using-a-closure)
            - [Using a Custom Class](#using-a-custom-class)
        - [Default Error Handler](#default-error-handler)
        - [About AuthAttemptException](#about-authattemptexception)

## Installation and Setup

This package makes use of the  [aws-sdk-php-laravel](https://github.com/aws/aws-sdk-php-laravel) package. As well as setting up and configuring this package you'll also need to configure [aws-sdk-php-laravel](https://github.com/aws/aws-sdk-php-laravel) for the authentication to work. Instructions on how to do this are below. If you've already installed, set up and configured [aws-sdk-php-laravel](https://github.com/aws/aws-sdk-php-laravel) you can skip the parts where it's mentioned below.

### Install

Add `pallant/laravel-aws-cognito-auth` to `composer.json` and run `composer update` to pull down the latest version:

```
"pallant/laravel-aws-cognito-auth": "~1.0"
```

Or use `composer require`:

```
composer require pallant/laravel-aws-cognito-auth
```

Add the service provider and the [aws-sdk-php-laravel](https://github.com/aws/aws-sdk-php-laravel) service provider to the `providers` array in `config/app.php`.

```php
'providers' => [
    ...
    Aws\Laravel\AwsServiceProvider::class,
    Endemol\AwsCognitoAuth\CognitoUserServiceProvider::class,
    Endemol\AwsCognitoAuth\CognitoAuthServiceProvider::class,
    ...
]
````

Open `app/Http/Kernel.php` and replace the default `\Illuminate\Session\Middleware\AuthenticateSession::class` middleware with `\Endemol\AwsCognitoAuth\AuthenticateSession::class,`.

```php
protected $middlewareGroups = [
    'web' => [
        ...
        \Endemol\AwsCognitoAuth\AuthenticateSession::class,
        ...
    ],
];
```

Publish the config files and default views:

```
php artisan vendor:publish --provider="Endemol\AwsCognitoAuth\CognitoAuthServiceProvider"
php artisan vendor:publish --provider="Aws\Laravel\AwsServiceProvider"
```

### Configure

Open `config/auth.php` and change the guard and user provider config to use cognito:

```php
    'guards' => [
        'web' => [
            'driver' => 'aws-cognito',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],
    ...
    'providers' => [
        'users' => [
            'driver' => 'aws-cognito-user-provider'
        ],
    ],
```

Set environment variables for your cognito user pool id and client id. These are read in `config/aws-cognito-auth.php`:
```
export AWS_COGNITO_IDENTITY_APP_CLIENT_ID=<client-id>
export AWS_COGNITO_IDENTITY_POOL_ID=<pool-id>
```

If running from outside of AWS, set your key and secret key:
```
export AWS_SECRET_ACCESS_KEY=<secret access key>
export AWS_ACCESS_KEY=<access key>
```
And add the following to config/aws.php:
```
'credentials' => [
    'key' => env('AWS_ACCESS_KEY', ''),
    'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
],
```

In `config/aws-cognito-auth.php`, set the user attributes that you want to populate from cognito. By default we populate email and phone_number:
```
    'user-attributes' => [
        'email',
        'phone_number'
    ],
```

Make your App/User.php class extend from CognitoUser, and add the attributes that you are populating from cognito, eg:
```php
namespace App;

use Endemol\AwsCognitoAuth\CognitoUser;

class User extends CognitoUser
{
    protected $email;
    protected $phone_number;
}
```

Add authentication routes to your `routes/web.php` file:
```php
Route::get('/', '\Endemol\AwsCognitoAuth\HomeController@show');
Route::get('/home', '\Endemol\AwsCognitoAuth\HomeController@show');

Auth::routes();

Route::get('register', [
    'as' => 'register',
    'uses' => '\Endemol\AwsCognitoAuth\CognitoRegisterController@showRegistrationForm'
]);
Route::post('register', [
    'as' => '',
    'uses' => '\Endemol\AwsCognitoAuth\CognitoRegisterController@register'
]);

Route::get('/verification', '\Endemol\AwsCognitoAuth\CognitoRegisterController@verification')->name('verification');
Route::post('verify', '\Endemol\AwsCognitoAuth\CognitoRegisterController@verify')->name('verify');
```

Set `app\Http\Controllers\Auth\LoginController.php` to use username as username (By default laravel sets it to email). Add the following:
```php
public function username()
{
    return 'username';
}
```

If you now run `php artisan serve` from the terminal you should be able to use your cognito setup at localhost:8000

New controllers can extend from CognitoController to add themselves into the authentication mechanism.