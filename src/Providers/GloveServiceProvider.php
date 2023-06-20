<?php

namespace ElleTheDev\Glove\Providers;

use ElleTheDev\Glove\GloveExceptionHandler;
use Illuminate\Support\ServiceProvider;

class GloveServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/glove.php'       => config_path('glove.php'),
            __DIR__.'/../../config/glove-codes.php' => config_path('glove-codes.php'),
            __DIR__.'/../../resources/views'        => resource_path('views/vendor/glove')
        ]);

        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'glove');
    }

    public function register()
    {
        // Override local Handler class to let Glove take control of exception
        // handling globally
        $this->app->singleton($this->app->config->get('glove.appHandler'), function ($app) {
            return $app->make(GloveExceptionHandler::class);
        });
    }
}
