<?php

namespace NinjahZA\AwsCognitoAuth;

use RuntimeException;

class AuthAttemptException extends RuntimeException
{
    /**
     * @var \Pallant\LaravelAwsCognitoAuth\AuthAttempt
     */
    protected $response;

    /**
     * AuthAttemptException constructor.
     *
     * @param \Pallant\LaravelAwsCognitoAuth\AuthAttempt $response
     */
    public function __construct(AuthAttempt $response)
    {
        $this->response = $response->getResponse();

        parent::__construct('Unable to authenticate', 0, null);
    }

    /**
     * @return \Pallant\LaravelAwsCognitoAuth\AuthAttempt
     */
    public function getResponse()
    {
        return $this->response;
    }
}
