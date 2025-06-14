<?php

namespace Nika\LaravelComments\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nika\LaravelComments\LaravelCommentsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        $commentsMig = include __DIR__ . '/../database/migrations/create_comments_table.php.stub';
        $commentsMig->up();

        /*
         * Migrations Inside tests
         */
        foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
        }

    }

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'Nika\\LaravelComments\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelCommentsServiceProvider::class,
        ];
    }
}
