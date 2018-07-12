<?php

namespace NinjahZA\AwsCognitoAuth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CognitoRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function register(Request $request)
    {
        $userAttributes = [];
        $attributeNames = config('aws-cognito-auth.user-attributes');
        foreach ($attributeNames as $attribute) {
            array_push($userAttributes, [
                "Name" => $attribute,
                "Value" => $request->input($attribute)
            ]);
        }
        $result = Auth::register($request->input('username'), $request->input('password'), $userAttributes);
        if ($result->successful()) {
            session()->flash('username', $request->input('username'));
            session()->flash('verifyMethod', $result->getResponse()['CodeDeliveryDetails']['DeliveryMedium']);
            return redirect()->route( 'verification' );
        } else {
            return redirect()->route( 'register' )->withErrors([$result->getResponse()['exception']]);
        }
    }

    public function verification()
    {
        session()->keep(['username']);
        session()->keep(['verifyMethod']);
        return view('auth.verification');
    }

    protected function verify(Request $request)
    {
        $result = Auth::verify(session()->get('username'), $request->input('code'));
        if ($result->successful()) {
            return redirect()->route( 'login' );
        } else {
            session()->keep(['username']);
            session()->keep(['verifyMethod']);
            return redirect()->route( 'verification' )->withErrors([$result->getResponse()['exception']]);
        }
    }
}
