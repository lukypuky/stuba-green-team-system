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
                'success_report_save' => Session::get('success_report_save'),
                'success_report_update_save' => Session::get('success_report_update_save'),
                'success_report_delete' => Session::get('success_report_delete'),
                'success_task_save' => Session::get('success_task_save'),
                'success_task_update_save' => Session::get('success_task_update_save'),
                'success_task_delete' => Session::get('success_task_delete'),
                'success_attendance_save' => Session::get('success_attendance_save'),
                'success_order_save' => Session::get('success_order_save'),
                'success_order_update_save' => Session::get('success_order_update_save'),
                'success_order_delete' => Session::get('success_order_delete'),
                ''
            ];
        });

        Inertia::share([
            'errors' => function(){
                return Session::get('errors') ? Session::get('errors')->getBag('default')->getMessages() : (Object)[];
            }
        ]);
    }
}
