# This is my package core-modules-maker

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-core-modules/core-modules-maker.svg?style=flat-square)](https://packagist.org/packages/laravel-core-modules/core-modules-maker)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/laravel-core-modules/core-modules-maker/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/laravel-core-modules/core-modules-maker/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/laravel-core-modules/core-modules-maker/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/laravel-core-modules/core-modules-maker/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-core-modules/core-modules-maker.svg?style=flat-square)](https://packagist.org/packages/laravel-core-modules/core-modules-maker)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/core-modules-maker.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/core-modules-maker)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require laravel-core-modules/core-modules-maker
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="core-modules-maker-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="core-modules-maker-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="core-modules-maker-views"
```

## Basic Usage

### Migration Modules

You can use the following Artisan command to generate a new enum class:

```php
php artisan generate:migration CreateTestsTable --create=tests --columns='{"reference": {"type": "string", "nullable": false, "default": null}}' --model=Test
```

Now, you just need to add the possible values your enum can have as constants.

```php
<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserType extends Enum
{
    const Administrator = 0;
    const Moderator = 1;
    const Subscriber = 2;
    const SuperAdministrator = 3;
}
```

## Usage

```php
$coreModuleMaker = new LaravelCoreModule\CoreModuleMaker();
echo $coreModuleMaker->echoPhrase('Hello, LaravelCoreModule!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Corine BOCOGA](https://github.com/cocorine999)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
