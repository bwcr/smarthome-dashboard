<?php

namespace App\Http\Controllers;

use Google\Cloud\Datastore\V1\Key;
use Illuminate\Http\Request;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ArduinoController extends Controller
{
    public function index()
    {
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();

        $user = Session::get('user')->uid;
        $collection = $firestore->collection('users')->document($user)->collection('devices');
        $gardenSnapshot = $collection->where('device_type','=','Garden')->documents();
        $lampSnapshot = $collection->where('device_type', '=', 'Lamp')->documents();
        $doorSnapshot = $collection->where('device_type', '=', 'Door')->documents();
        $tempSnapshot = $collection->where('device_type', '=', 'Temp')->documents();

        return view('arduino.list')->with(['garden' => $gardenSnapshot, 'lamp' => $lampSnapshot, 'temp' => $tempSnapshot, 'door' => $doorSnapshot]);
    }

    public function create(Request $request)
    {
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();
        $auth = app('firebase.auth');

        $dataProperties = [
            'device_name' => $request['device_name'],
            'device_type' => $request['device_type'],
            'ip_address' => $request['ip_address'],
            'wifi_ssid' => $request['wifi_ssid'],
            'wifi_password' => $request['wifi_password'],
            'sensor' => [],
            'date_created' => date('Y/m/d')
        ];

        $validator = Validator::make($request->all(), [
            'ip_address' => 'required|ip',
            'device_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'wifi_ssid' => 'required',
            'wifi_password' => 'required|min:8|alpha_num'
        ])->validate();

        $user = Session::get('user')->uid;
        $collection = $firestore->collection('users')->document($user)->collection('devices');
        $addDevice = $collection->add($dataProperties);
        return redirect()->route('arduino');
    }

    public function read($id)
    {
        $user = Session::get('user')->uid;

        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();
        $deviceList = $firestore->collection('users')->document($user)->collection('devices')->document($id);
        $snapshot = $deviceList->snapshot();


        if ($snapshot->exists()) {
            $data = $snapshot->data();
            $date = date("F d, Y", strtotime($data['date_created']));
            return view('arduino.device')->with(['data' => $data, 'date' => $date, 'id' => $id]);
            print_r($snapshot['device_name']);
        } else {
            abort(404);
        }
    }

    public function update(Request $data, $id)
    {
        $user = Session::get('user')->uid;

        $array = [
            'device_name' => $data['device_name'],
            'ip_address' => $data['ip_address'],
            'wifi_ssid' => $data['wifi_ssid'],
            'wifi_password' => $data ['wifi_password']
        ];

        $validator = Validator::make($data->all(), [
            'ip_address' => 'required|ip',
            'wifi_password' => 'required|min:8'
        ]);

        if($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        else
        {
            $firestore = app('firebase.firestore');
            $firestore = $firestore->database();
            $deviceList = $firestore->collection('users')->document($user)->collection('devices')->document($id)->set($array, ['merge' => true]);
            $data->session()->flash('success', 'Data has been successfully updated');
            return redirect()->route('arduino.read',$id);
        }

    }

    public function delete(Request $request, $id)
    {
        $firestore = app('firebase.firestore');
        $auth = app('firebase.auth');
        $firestore = $firestore->database();
        $user = Session::get('user')->uid;
        $email = $auth->getUser($user)->email;


        try
        {
            $signInResult = $auth->signInWithEmailAndPassword($email, $request['password']);
            $delete = $firestore->collection('users')->document($user)->collection('devices')->document($id)->delete();
            return redirect()->route('arduino')->with(['message' => 'Your device has been successfully deleted']);
        }
        catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn $e)
        {
            $message = $e->getMessage();
            if($message == 'INVALID_PASSWORD')
            {
                $message = 'The password is incorrect';
            }
            return redirect()->route('arduino.read', $id)
            ->withInput()
            ->withErrors(['password' => $message]);
        }

    }
}
