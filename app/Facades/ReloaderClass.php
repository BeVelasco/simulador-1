<?php
    namespace App\Facades;

    use Illuminate\Support\Facades\Facade;

    class ReloaderClass extends Facade{
        protected static function getFacadeAccessor() { return 'reloader'; }
    }