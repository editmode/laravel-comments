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

## Config

You can publish the config file with:

```bash
php artisan vendor:publish --tag="comments-config"
```

### Like/Dislike Feature

You can optionally enable the **like/dislike** feature in the package **config**.
To enable this feature:

1. Set `like_dislike_feature` to `true` in `config/comments.php`.
2. Add the `HasReactions` trait to your custom comment model.

```php
use Nika\LaravelComments\Traits\HasReactions;

class CustomComment extends \Nika\LaravelComments\Models\Comment
{
    use HasReactions;
}
```

## Migrations

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Nika\LaravelComments\LaravelCommentsServiceProvider" --tag="comments-migrations"
```

Then run the migrations:

```bash
php artisan migrate
```

> ⚠️ The `create_comment_reactions_table` migration will be skipped unless the `like_dislike_feature` setting is enabled
> in your `config/comments.php` file.
> If you plan to use the like/dislike feature, make sure to publish the **config** first and set `like_dislike_feature`
> to true before running `php artisan migrate`.
</file>

## Routes

You can register the package's routes by calling the macro in your `routes/web.php`:

```php
Route::comments();
```

This will automatically register routes like `GET /comments`, and if the like/dislike feature is enabled,
also `POST /comments/{comment}/react/{type}` — where `{type}` must be either `like` or `dislike`.

### Published Routes:

| Method   | URI                       | Name                    |
|----------|---------------------------|-------------------------|
| **GET**  | `/comments`               | comments.index          |
| **POST** | `/{comment}/react/{type}` | comment.reaction.toggle |

## Views

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
