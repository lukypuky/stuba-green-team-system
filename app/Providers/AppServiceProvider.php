<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inertia::share('flash', function(){
            return [
                'success_object_save' => Session::get('success_object_save'),
                'success_object_update_save' => Session::get('success_object_update_save'),
                'success_object_delete' => Session::get('success_object_delete'),
                'unsuccess_object_delete' => Session::get('unsuccess_object_delete'),
            ];
        });

        Inertia::share([
            'errors' => function(){
                return Session::get('errors') ? Session::get('errors')->getBag('default')->getMessages() : (Object)[];
            }
        ]);
    }
}
