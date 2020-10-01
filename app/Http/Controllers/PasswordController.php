<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        $oldPass = $request->current_password;
        $newPass = $request->password;
        $confirmPass = $request->password_confirmation;

        $array = [
            'password' => $newPass
        ];

        if($newPass != $confirmPass)
        {
            $message = "The password does not match";
            return redirect()
            ->route('profile')
            ->withInput()
            ->withErrors(['password_confirmation' => $message]);
        }
        else
        {
            $auth = app('firebase.auth');
            $user = Session::get('user');
            $uid = $auth->getUser($user);
            $email = $uid->email;
            $uid = $uid->uid;
            try
            {
                // $user = $auth->signInWithEmailAndPassword($email, $oldPass);
                $updatePassword = $auth->changeUserPassword($uid, $newPass);
                $firestore = app('firebase.firestore');
                $firestore = $firestore->database();
                $firestore->collection('users')->document($uid)
                ->set($array, ['merge' => true]);

                $message = 'Password has been succesfully updated';
                $request->session()->flash('success', $message);
                return redirect()->route('profile');
            }
            catch (\Kreait\Firebase\Exception\Auth\WeakPassword $e)
            {
                $message = $e->getMessage();
                return redirect()->route('profile')
                ->withInput()
                ->withErrors(['password' => $message]);
            }
        }
        return redirect()->route('profile');
    }
}
