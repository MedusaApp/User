<?php
namespace PersonalityUser;

Use Personality\Models\User;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        // Bouncer expects App\User and we're using App\Models\User

        if (class_exists('Illuminate\Foundation\AliasLoader')) {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('App\User', User::class);
        } else {
            class_alias('App\User', User::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}