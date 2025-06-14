# This is my package laravel-comments

[![Latest Version on Packagist](https://img.shields.io/packagist/v/editmode/laravel-comments.svg?style=flat-square)](https://packagist.org/packages/editmode/laravel-comments)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/editmode/laravel-comments/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/editmode/laravel-comments/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/editmode/laravel-comments/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/editmode/laravel-comments/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/editmode/laravel-comments.svg?style=flat-square)](https://packagist.org/packages/editmode/laravel-comments)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.



## Installation

You can install the package via composer:

```bash
composer require editmode/laravel-comments
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="comments-config"
```

You can optionally enable the like/dislike feature in the package config. If you choose to use it, make sure to run the `comment_likes` migration (`create_comment_likes_table.php`).

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="comments-migrations"
php artisan migrate
```

> **Note:** If you do not plan to use the like/dislike feature, you may skip running the `comment_likes` migration after publishing.

Optionally, you can publish the views using:

```bash
php artisan vendor:publish --tag="laravel-comments-views"
```

## Usage

```php
$laravelComments = new Nika\LaravelComments();
echo $laravelComments->echoPhrase('Hello, Nika!');
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

- [Nika](https://github.com/editmode)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
