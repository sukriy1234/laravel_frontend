<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    public function config()
    {
        if (Session::get('login')) {
            $headers = [
             'Content-Type' => 'application/json',
             'api_token' =>  Session::get('api_token'),
             'Authorization' => 'Bearer token',
         ];
            $client = new \GuzzleHttp\Client([ 'headers' => $headers ]);
        } else {
            $client = new \GuzzleHttp\Client();
        }
        return $client;
    }
}
