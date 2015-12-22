<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;

class AppServiceProvider extends ServiceProvider
{

    private $available = ['en', 'fr'];


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('findLocale', function() {
            // If compatible ISO code if provided in URL
            if (in_array(Request::segment(1), $this->available)) {
                $this->setLocale(Request::segment(1));
                return App::getLocale();
            }

            // Search for compatible ISO code in HTTP header
            foreach ($this->getSupportedByClient() as $iso) {
                if (in_array($iso, $this->available)) {
                    $this->setLocale($iso);
                    break;
                }
            }

            return false;
        });
    }

    private function getSupportedByClient()
    {
        $supportedByClient = explode(',', Request::server('HTTP_ACCEPT_LANGUAGE'));

        array_walk($supportedByClient, function($val) {
            return substr($val, 0, 2);
        });

        return $supportedByClient;
    }

    private function setLocale($locale)
    {
        setlocale(LC_TIME, $locale.'_'.strtoupper($locale).'.utf8');
        Carbon::setLocale($locale);
        App::setLocale($locale);
    }

}
