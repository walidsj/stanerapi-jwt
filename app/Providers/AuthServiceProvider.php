<?php

namespace App\Providers;

use App\Models\User;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            $authorization = $request->header('Authorization');

            $key = explode(' ', $authorization);
            if ($key[0] == 'Bearer' && !empty($key[1])) {
                $user = User::where('api_token', $key[1])->first();
                $origin = $request->header('Origin');
                $hostClient = explode(',', $user->hostClient);
                if (in_array($origin, $hostClient)) {
                    return $user;
                }
            }
        });
    }
}
