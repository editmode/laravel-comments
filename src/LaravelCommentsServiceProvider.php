<?php

namespace Nika\LaravelComments;

use Illuminate\Support\Facades\Route;
use Nika\LaravelComments\Http\Controllers\CommentController;
use Nika\LaravelComments\Http\Controllers\CommentReactionController;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelCommentsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-comments')
            ->hasConfigFile()
            //            ->hasViews()
            ->hasMigration('create_comments_table')
            ->hasMigration('create_comment_reactions_table');
        //            ->hasCommand(LaravelCommentsCommand::class);
    }

    public function registeringPackage(): void
    {
        Route::macro('comments', function ($baseUrl = 'comments') {
            Route::prefix($baseUrl)->group(function () {

                Route::get('/', fn () => 'OK!');

                Route::middleware('auth')->group(function () {
                    if (config('comments.like_dislike_feature')) {
                        Route::post('{comment}/react/{type}', [CommentReactionController::class, 'toggle'])
                            ->where('type', 'like|dislike')
                            ->name('comment.reaction.toggle');
                    }
                    Route::post('/', [CommentController::class, 'store'])
                        ->name('comment.store');

                    Route::patch('{comment}', [CommentController::class, 'update'])
                        ->name('comment.update');

                    Route::delete('{comment}', [CommentController::class, 'destroy'])
                        ->name('comment.destroy');
                });
            });
        });
    }
}
