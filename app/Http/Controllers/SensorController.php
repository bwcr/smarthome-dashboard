<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function create()
    {
        $firestore = app('firebase.firestore');

    }
}
