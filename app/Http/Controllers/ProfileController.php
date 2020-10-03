<?php

namespace App\Http\Controllers;

// use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Auth;

class ProfileController extends Controller
{
    //

    public function index()
    {
        $userSession = Session::get('user');
        // die($userSession);
        $auth = app('firebase.auth');
        $firestore = app('firebase.firestore');

        // $userId = $auth->getUser($userSession);
        // die($userId->uid);
        $firestore = $firestore->database();

        //Firestore
        $collectionReference = $firestore->collection('users');
        $documentReference = $collectionReference->document($userSession->uid);
        $snapshot = $documentReference->snapshot();

        $initial = substr($snapshot['first_name'], 0, 1) . substr($snapshot['last_name'], 0, 1);
        return view('profile.edit')->with(['snapshot' => $snapshot, 'initial' => $initial]);
    }

    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user()
        ]);
    }

    public function update(Request $request)
    {
        $auth = app('firebase.auth');
        $oldPass = $request['current_password'];
        $newPass = $request['password'];
    }
}
