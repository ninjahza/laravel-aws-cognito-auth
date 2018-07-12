<?php

namespace NinjahZA\AwsCognitoAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use View;

class HomeController extends CognitoAuthController
{
    public function show()
    {
        return view('home');
    }
}