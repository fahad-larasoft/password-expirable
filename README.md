# Password Expiry for Laravel 5.x

Password Strength has following characteristics:
- It will allow your to set Expiry time of user password and send them reset emails.
- It does support Laravel 5.1.* - 5.5.*

## Install

Via Composer

``` bash
$ composer require larasoft/password-expirable
```

You must include the service provider in config/app.php:

```php

'providers' => [
    ...
    Larasoft\PasswordExpiry\PasswordExpiryServiceProvider::class,
],
```

You need to migrate you database.

```bash
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Larasoft\PasswordExpiry\PasswordExpiryServiceProvider" --tag="config"
```

When published, the `config/password-expiry.php` config file contains:

```php
return [

      // # of Days: After which user password gets expired and user should receive password reset email/notification
      'expiry_days' => 2,
  
      // Expiry message to send in password email/notification
      'expiry_message' => 'It has been over :number days since you reset your password. Please update it now.',
  
      'strong_password_rules' => 'case_diff|numbers|letters|symbols'
];
```

You can change it according to your needs. 

## Usage

* Include Following trait in User Model 
``` php
use PasswordExpirable;
```


* You can get the datetime Carbon instance of "when the current password was set on user object"
``` php
$user->getCurrentPasswordSetTime();
```


* You can check if user password is expired?
``` php 
$user->isPasswordExpired();
```

* You can protect your routes from user with expired password 
by adding following middleware into your app/Http/Kernel.php and
applying it onto your required routes. You can change the name 'check-password-expired' how you like.
``` php 
protected $routeMiddleware = [
    ...
    'check-password-expired' => CheckPasswordExpired::class
]
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [:author_name][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/:vendor/:package_name.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/:vendor/:package_name/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/:vendor/:package_name.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/:vendor/:package_name.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/:vendor/:package_name.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/:vendor/:package_name
[link-travis]: https://travis-ci.org/:vendor/:package_name
[link-scrutinizer]: https://scrutinizer-ci.com/g/:vendor/:package_name/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/:vendor/:package_name
[link-downloads]: https://packagist.org/packages/:vendor/:package_name
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
