<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Nexmo\Laravel\Facade\Nexmo;

class SmsController extends Controller
{
    public function sendSms(Request $request)
    {
        // return $request;
        Nexmo::message()->send([
            'to' => $request->mobile,
            'from' => '6281228822612',
            'text' => 'Coba sms pakai ini'
        ]);

        Session::flash('success', 'Message sent');
        return redirect('/');
    }
}