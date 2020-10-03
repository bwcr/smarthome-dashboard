<?php

namespace App\Http\Controllers;

use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
// use Firebase\Auth\Token\Exception\InvalidToken;
// use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function index()
    {
        if(Session::has('user'))
        {
            return redirect()->route('profile');
        }
        else
        {
            return view('auth.login');
        }
    }

    public function user(Request $request)
    {
        $email = $request->email;
        $pass = $request->password;

        $auth = app('firebase.auth');

        try
        {
            $signIn = $auth->signInWithEmailAndPassword($email, $pass);
            $user = $auth->getUserByEmail($email);

            $verified = $user->emailVerified;

            if($verified == null)
            {
                // Session::flash('message', 'You have not verifiy your email yet. Consider to check your email for the verification link');
                return redirect()->route('login')
                ->with('message', 'You have not verifiy your email yet. Consider to check your email for the verification link');
            }
            else
            {
                $request->session()->put('tokenResponse', $signIn->asTokenResponse());
                return redirect()->route('profile');
            }

        } catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn | \Kreait\Firebase\Exception\InvalidArgumentException | \Kreait\Firebase\Exception\Auth\InvalidPassword $e)
        {
            $message = $e->getMessage();
            if($message == 'EMAIL_NOT_FOUND' || $message == 'INVALID_PASSWORD')
            {
                $message = 'The email or password is incorrect';
            }
            return redirect()->route('login')
            ->withInput()
            ->withErrors(['email' => $message]);
        }

        // $request->session()->put('uid', $uid);
        // $request->session()->put('email', $email);

        // return view('profile.edit');
    }

    public function logout(Request $request)
    {
        // $request->session()->forget('user','refreshToken');
        $auth = app('firebase.auth');
        $uid = Session::get('user')->uid;
        $auth->revokeRefreshTokens($uid);
        $tokenResponse = Session::get('tokenResponse');
        $tokenId = $tokenResponse['id_token'];

        try
        {
            $verifiedIdToken = $auth->verifyIdToken($tokenId, $checkIfRevoked = true);
        }
        catch (RevokedIdToken $e)
        {
            $request->session()->flush();
            return redirect()->route('login')->with(['message' => $e]);
        }
    }
}
