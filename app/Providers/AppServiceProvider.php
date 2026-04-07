<?php

namespace App\Providers;

use App\Support\WindowsFilesystem;
use Illuminate\Database\Events\ConnectionEstablished;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('files', function () {
            return new WindowsFilesystem;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }

        Event::listen(ConnectionEstablished::class, function (ConnectionEstablished $event): void {
            if ($event->connection->getDriverName() !== 'sqlite') {
                return;
            }

            $event->connection->unprepared('PRAGMA journal_mode = MEMORY;');
            $event->connection->unprepared('PRAGMA synchronous = OFF;');
            $event->connection->unprepared('PRAGMA temp_store = MEMORY;');
        });
    }
}
