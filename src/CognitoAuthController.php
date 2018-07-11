<?php

namespace Endemol\AwsCognitoAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CognitoAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}