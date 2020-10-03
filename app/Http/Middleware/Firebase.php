<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use Illuminate\Http\Request;

class Firebase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = app('firebase.auth');
        if(Session::has('tokenResponse'))
        {
            $tokenResponse = Session::get('tokenResponse');
            $tokenId = $tokenResponse['id_token'];

            try
            {
                $verifiedIdToken = $auth->verifyIdToken($tokenId, $checkIfRevoked = true);
                $uid = $verifiedIdToken->getClaim('sub');
                $user = $auth->getUser($uid);
                $request->session()->flash('user', $user);

                return $next($request);
            }
            catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn | \InvalidArgumentException | InvalidToken | RevokedIdToken $e)
            {
                $request->session()->flush();
                return redirect()->route('login')->with('message', $e->getMessage());
            }
        }
        else
        {
            return redirect()->route('login');
        }

    }
}
