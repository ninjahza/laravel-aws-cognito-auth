<?php
/**
 * Created by PhpStorm.
 * User: david.bramwell
 * Date: 06/07/2018
 * Time: 14:15
 */

namespace Endemol\AwsCognitoAuth;

use Illuminate\Support\ServiceProvider as ServiceProvider;
use Auth;


class CognitoUserServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerProvider();
    }

    protected function registerProvider()
    {
        Auth::provider('aws-cognito-user-provider', function($app, array $config) {
            $client = $this->app->make('aws')->createCognitoIdentityProvider();
            return new CognitoUserProvider($client, $this->app['config']['aws-cognito-auth']);
        });
    }
}