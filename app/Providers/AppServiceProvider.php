<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use JoeDixon\Translation\Scanner;
use JoeDixon\Translation\Drivers\Translation;
use App\Http\Package\LaravelTranslation\TranslationManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind('path.public', function() {
        //     return base_path().'/public';
        // });
        $this->app->singleton(Translation::class, function ($app) {
            return (new TranslationManager($app, $app['config']['translation'], $app->make(Scanner::class)))->resolve();
        });
        
        if(env('FORCE_HTTPS_URL')) URL::forceScheme('https'); 
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
