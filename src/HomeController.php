<?php

namespace App\Http\Controllers;

use Endemol\AwsCognitoAuth\CognitoAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use View;

class FonikController extends CognitoAuthController
{
    public function show()
    {
        return view('home');
    }
}