<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Support\Facades\Session;

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
        $idTokenString = Session::get('user');

        try {
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);

        } catch (\InvalidArgumentException | InvalidToken $e) {
            $request->session()->forget('user');
            return redirect()->route('login', $e->getMessage());
        }

        $uid = $verifiedIdToken->getClaim('sub');
        $user = $auth->getUser($uid);
        return $next($request);
    }
}
