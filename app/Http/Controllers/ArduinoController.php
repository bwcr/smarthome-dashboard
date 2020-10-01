<?php

namespace App\Http\Controllers;

use Google\Cloud\Datastore\V1\Key;
use Illuminate\Http\Request;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ArduinoController extends Controller
{
    // public function create(Request $data)
    // {
    //     try
    //     {
    //         $input = $data->all();
    //         $database = app('firebase.database');
    //         $newPostKey = $database->getReference('smarthomeproject-d187f/lampu')->push->getKey()
    //         $updates = [

    //         ]
    //         $reference = $database->getReference('smarthomeproject-d187f/')
    //         ->update($updates);
    //     }
    // }

    public function index()
    {
        $firestore = app('firebase.firestore');
        $firestore = $firestore->database();
        $user = Session::get('user');
        $collection = $firestore->collection('users')->document($user)->collection('devices');
        $farmSnapshot = $collection->where('device_type','=','Kebun')->documents();
        $lampSnapshot = $collection->where('device_type', '=', 'Lampu')->documents();

        return view('arduino.list')->with(['farm' => $farmSnapshot, 'lamp' => $lampSnapshot]);
    }

    public function create()
    {
        $firestore = app('firebase.firestore');
        $auth = app('firebase.auth');
    }

    public function read($id)
    {
        $user = Session::get('user');

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
        $user = Session::get('user');

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
            $firestore = new FirestoreClient(['projectId' => 'smarthomeproject-d187f']);
            $deviceList = $firestore->collection('users')->document($user)->collection('devices')->document($id)->set($array, ['merge' => true]);
            $data->session()->flash('success', 'Data has been successfully updated');
            return redirect()->route('arduino.read',$id);
        }

    }
}
