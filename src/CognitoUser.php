<?php

namespace Endemol\AwsCognitoAuth;

use Illuminate\Contracts\Auth\Authenticatable;

class CognitoUser implements Authenticatable
{
    public $username;

    public function __construct($userData)
    {
        $this->username = $userData->get('Username');
        $attributes = config('aws-cognito-auth.user-attributes');
        foreach ($attributes as $attribute) {
            $this->$attribute = $this->getAttribute($userData, $attribute);
        }
    }

    private function getAttribute($userdata, $attr) {
        foreach ($userdata["UserAttributes"] as $arr) {
            if ($arr['Name'] == $attr) {
                return $arr['Value'];
            }
        }
        return null;
    }

    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    /**
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getAuthPassword()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        // Return the token used for the "remember me" functionality
    }

    /**
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // Store a new token user for the "remember me" functionality
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        // Return the name of the column / attribute used to store the "remember me" token
    }

    /*
     *
     */
}
