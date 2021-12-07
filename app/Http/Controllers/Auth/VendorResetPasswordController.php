<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Password;
use Auth;
use Illuminate\Http\Request;

class VendorResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/vendor';

    public function __construct()
    {
    $this->middleware('guest:vendor');
    }

    protected function guard()
    {
        return Auth::guard('vendor');
    }

    protected function broker()
    {
        return Password::broker('vendors');
    }

    public function showResetForm(Request $request, $token = null)
    {   
        return view('auth.passwords.vendor-reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

}
