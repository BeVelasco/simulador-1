<?php

    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\App;

    class SimuladorServiceProvider extends ServiceProvider
    {
        /**
        * Bootstrap the application services.
        *
        * @return void
        */
        public function boot(){
            //
        }

        /**
         * Register the application services.
         *
         * @return void
         */
        public function register(){
            App::bind('simulador', function(){
                return new \App\Helpers\SimuladorHelper;
            });
        }
}