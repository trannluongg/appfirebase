<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 10/3/18
 * Time: 4:14 PM
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $this->registerRepositoryFrontend();
    }

    private function registerRepositoryFrontend()
    {
        $arrRepositoryRegister = [
            'FirebaseDeviceToken\FirebaseDeviceTokenRepository',
        ];

        $namespace_frontend    = "App\Repository\\";
        foreach ($arrRepositoryRegister as $repository) {
            $this->app->singleton(
                $namespace_frontend . $repository . 'Interface',
                $namespace_frontend . $repository
            );
        }
    }
}