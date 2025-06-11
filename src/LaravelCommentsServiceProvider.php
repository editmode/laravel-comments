<?php

namespace Nika\LaravelComments;

use Nika\LaravelComments\Commands\LaravelCommentsCommand;
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
            ->hasMigration('create_laravel_comments_table');
        //            ->hasCommand(LaravelCommentsCommand::class);
    }
}
