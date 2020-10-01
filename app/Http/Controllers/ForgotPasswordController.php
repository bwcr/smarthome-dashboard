<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    public function index(Request $request)
    {
        return view('auth.passwords.email');
    }

    public function reset(Request $request)
    {
        $auth = app('firebase.auth');

        $email = $request['email'];

        try
        {
            $auth->sendPasswordResetLink($email);
            Session::flash('message', 'Reset password link has been sent to your email');
            return redirect()->route('login');
        }
        catch (\Kreait\Firebase\Exception\Auth\EmailNotFound | \Kreait\Firebase\Auth\SendActionLink\FailedToSendActionLink $e)
        {
            $message = $e->getMessage();
                return redirect()->route('user.forgot')
                ->withInput()
                ->withErrors(['email' => $message]);
        }

    }
}
