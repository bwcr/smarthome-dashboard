<?php
namespace App\Http\Controllers;

use App\Http\Middleware\Firebase;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Firestore;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class FirebaseController extends Controller
{
    public function index(){
        return view('auth.register');
    }

    public function create(Request $data)
    {
        // if(request()->ajax()){
        //     $auth = app('firebase.auth');
        //     $firestore = new FirestoreClient([
        //         'projectId' => 'smarthomeproject-d187f',
        //     ]);

        //     $userProperties = [
        //         'first_name' => $data['first_name'],
        //         'last_name' => $data['last_name'],
        //         'email' => $data['email'],
        //         'password' => $data['password'],
        //     ];

        //     $user = $data['userId'];
        //     $firestore->collection('users')->document($user)->set($userProperties);
        //     Session::flash('success', 'You have succesfully signed up! Be sure to check your email for verification to sign in');
        //     return redirect()->route('login');
        // } else {
        //     die();
        // }

        $auth = app('firebase.auth');
        $firestore = app('firebase.firestore');

        $fullName = $data['first_name'] . ' ' . $data['last_name'];

        $userProperties = [
            'displayName' => $fullName,
            'email' => $data['email'],
            'password' => $data['password'],
            'password_confirmation' => $data['password_confirmation']
        ];

        $validator = Validator::make($data->all(), [
            'email' => 'required|email',
            'first_name' => 'required|alpha',
            'last_name' => 'alpha',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
            ->withErrors($validator)
            ->withInput();
        }

        else
        {
            try
            {
                $createdUser = $auth->createUser($userProperties);

                //Firestore
                $userProperties = [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                ];

                $user = $auth->getUserByEmail($data['email']);
                $uid = $user->uid;

                $firestore = $firestore->database();

                $firestore->collection('users')->document($uid)->set($userProperties);

                //Send email
                $sendEmail = $auth->sendEmailVerificationLink($data['email']);

                Session::flash('success', 'You have succesfully signed up! Be sure to check your email for verification to sign in');
                return redirect()->route('login');
            }
            catch (\Kreait\Firebase\Exception\Auth\EmailExists $e)
            {
                $message = $e->getMessage();
                return redirect()->route('register')
                ->withInput()
                ->withErrors(['email' => $message]);
            }
        }
    }

    public function update(Request $data)
    {

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $userProperties = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email']
        ];

        $user = Session::get('user');

        $validator = Validator::make($data->all(), [
            'email' => 'required|email',
            'first_name' => 'required|alpha',
            'last_name' => 'alpha'
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile')
            ->withErrors($validator)
            ->withInput();
        }

        else
        {
            try
            {
                $auth = app('firebase.auth');
                $auth->changeUserEmail($user, $data['email']);

                //Update Firestore
                $firestore->collection('users')->document($user)->set($userProperties, ['merge' => true]);
                $data->session()->flash('success', 'Pembaruan data berhasil');
                return redirect()->route('profile');
            }
            catch (\Kreait\Firebase\Exception\Auth\AuthError | \Kreait\Firebase\Exception\Auth\EmailExists $e)
            {
                $message = $e->getMessage();
                return redirect()->route('login')
                ->withInput()
                ->withErrors(['email' => $message]);
            }
        }
    }

    public function delete(Request $data)
    {

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        try
        {
            $auth = app('firebase.auth');
            $pass = $data['password_delete'];
            $uid = Session::get('user');
            $email = $auth->getUser($uid)->email;

            $signInResult = $auth->signInWithEmailAndPassword($email, $pass);
            $auth->deleteUser($uid);
            $firestore->collection('users')->document($uid)->delete();

            $data->session()->forget('user');
            $data->session()->flash('success', 'You have successfully deleted your account');

            return redirect()->route('logout');

        }
        catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn | \Kreait\Firebase\Exception\Auth\AuthError $e)
        {
            $message = $e->getMessage();
            return redirect()->route('profile')
            ->withInput()
            ->withErrors(['password_delete' => $message]);
        }
    }
}
