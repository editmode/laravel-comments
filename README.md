# Laravel Comments

[![Latest Version on Packagist](https://img.shields.io/packagist/v/editmode/laravel-comments.svg?style=flat-square)](https://packagist.org/packages/editmode/laravel-comments)
[![Total Downloads](https://img.shields.io/packagist/dt/editmode/laravel-comments.svg?style=flat-square)](https://packagist.org/packages/editmode/laravel-comments)

A customizable Laravel package to easily add comments and threaded discussions to any model — ideal for blog posts, user profiles, product reviews, or any other entity in your app.

Supports optional like/dislike reactions, nested replies, and is designed to integrate smoothly with Inertia/React or Blade.

## Table of Contents

- [Installation](#installation)
- [Quickstart](#quickstart)
- [Config](#config)
- [Like/Dislike Feature](#likedislike-feature)
- [Migrations](#migrations)
- [Routes](#routes)
- [Development Tips](#development-tips)
- [Testing](#testing)
- [Changelog](#changelog)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

```bash
composer require editmode/laravel-comments
```

## Quickstart

After installing the package, it's recommended that you create your own custom `Comment` model that extends the base model provided by the package. This gives you full flexibility to modify, extend, or customize comment behavior as needed.

### 1. Install the package

```bash
composer require editmode/laravel-comments
```
### 2. Publish the configuration file (optional but recommended):
```bash
php artisan vendor:publish --tag=comments-config
```

### 2.5. Publish the migrations

The package includes migrations to create the comments and comment reactions tables.  
You should publish them using:

```bash
php artisan vendor:publish --tag="comments-migrations"
```

> 🛑 **Important:** If you plan to use the like/dislike feature, make sure to also publish the config file first and enable it in `config/comments.php` by setting `like_dislike_feature` to `true`. Otherwise, the `comment_reactions` table will not be created during migration.

### 3. Create your own Comment model by extending the base comment model:


> 🚨 **VERY IMPORTANT**  
> For Laravel's polymorphic relationships to work *automatically* without manual configuration, your custom model **must** be named `Comment`.
> If you use any other name (like `UserComment`, `PostComment`, etc.), morph types like `commentable_type` will not resolve correctly unless you manually configure a morph map. Laravel automatically handles this when your model is named `Comment`.

```php
use Nika\LaravelComments\Models\Comment as BaseComment;

        
class Comment extends BaseComment
         ↑
{
    // Add your own relationships, scopes, or overrides here
}
```

### 4. Update your configuration file `config/comments.php` to use your custom Comment model:

```php
return [
    'model' => App\Models\Comment::class,
];
```


This setup allows you to fully control how comments behave in your application while leveraging the core features provided by the package.

---

### 5. Attach a comment to a model

You can now attach comments to any model by using the `HasComments` trait on that model.

```php
use Nika\LaravelComments\Traits\HasComments;

class Post extends Model
{
    use HasComments;
}
```

Then, to add a comment as the currently authenticated user:

```php
$post = Post::find(1);

$post->comment('This is a comment from the logged-in user');
```

Or explicitly pass a user:

```php
$post->commentAsUser($user, 'This is a comment from a specific user');
```

This allows you to associate comments with any model that uses the `HasComments` trait.

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
use Nika\LaravelComments\Models\Comment as BaseComment;
use Nika\LaravelComments\Traits\HasReactions;

class Comment extends BaseComment
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

## Routes

You can register the package's routes by calling the macro in your `routes/web.php`:

```php
Route::comments();
```

This will automatically register routes like `GET /comments`, and if the like/dislike feature is enabled,
also `POST /comments/{comment}/react/{type}` — where `{type}` must be either `like` or `dislike`.

By default, routes are prefixed with `/comments`. You can change this by passing a different base URL
to `Route::comments('your-prefix')`.
> 💡 See [Development Tips](#development-tips) for filtering the route list.

### Published Routes:

| Method     | URI                                | Name                    |
|------------|------------------------------------|-------------------------|
| **GET**    | `/{prefix}`                        | —                       |
| **POST**   | `/{prefix}`                        | comment.store           |
| **PATCH**  | `/{prefix}/{comment}`              | comment.update          |
| **DELETE** | `/{prefix}/{comment}`              | comment.destroy         |
| **POST**   | `/{prefix}/{comment}/react/{type}` | comment.reaction.toggle |

[//]: # (## Views)

[//]: # ()
[//]: # (```bash)

[//]: # (php artisan vendor:publish --tag="laravel-comments-views")

[//]: # (```)



## Development Tips

### Filtering Routes

To list only the routes registered by this package:

```bash
php artisan route:list --path=comments
```

This helps when debugging or inspecting how the package integrates into your app.

[//]: # (> ⚠️ If you want related comments to be deleted when the parent is deleted, set `delete_with_parent` to `true`)

[//]: # (> in `config/comments.php`)
## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

[//]: # (## Contributing)

[//]: # ()
[//]: # (Please see [CONTRIBUTING]&#40;CONTRIBUTING.md&#41; for details.)

[//]: # (## Security Vulnerabilities)

[//]: # ()
[//]: # (Please review [our security policy]&#40;../../security/policy&#41; on how to report security vulnerabilities.)

## Credits

- [Nika](https://github.com/editmode)

[//]: # (- [All Contributors]&#40;../../contributors&#41;)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
