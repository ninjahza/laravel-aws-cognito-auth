<?php

namespace Endemol\AwsCognitoAuth;

use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;

class CognitoUserProvider implements UserProvider
{

    protected $client;
    protected $config;

    public function __construct(CognitoIdentityProviderClient $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }


    public function retrieveById($username)
    {
        try {
            $userData = $this->client->adminGetUser([
                'UserPoolId' => $this->config['pool-id'],
                'Username' => $username
            ]);
            return new User($userData);
        } catch (CognitoIdentityProviderException $e) {
            return null;
        }
    }

    public function retrieveByToken($identifier, $token)
    {
        return $this->retrieveById($identifier);
    }


    public function updateRememberToken(Authenticatable $user, $token)
    {

    }

    public function retrieveByCredentials(array $credentials)
    {

    }

    protected function getGenericUser($user)
    {

    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return false;
    }
}
