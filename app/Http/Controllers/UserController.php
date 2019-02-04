<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        if (Session::get('login')) {
            return view('home');
        } else {
            return view('login');
        }
    }
    public function login(Request $request)
    {
        //send request to api
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'http://localhost:8080/login', [
         'form_params' => [
             'username' => $request->username,
             'password' => $request->password
          ]
      ]);
        $response = $response->getBody()->getContents();

        //read response from api
        $check = json_decode($response);

        //if response success
        if ($check->success) {
            //save data to session
            $data = json_decode($check->message)[0];
            Session::put('id', $data->id);
            Session::put('username', $data->username);
            Session::put('api_token', $data->api_token);
            Session::put('flag', $data->flag);
            Session::put('login', true);
        }
        return $response;
    }
    public function logout()
    {
        $headers = [
              'Content-Type' => 'application/json',
              'api_token' =>  Session::get('api_token'),
              'Authorization' => 'Bearer token',
         ];
        $client = new \GuzzleHttp\Client([ 'headers' => $headers ]);
        $response = $client->request('POST', 'http://localhost:8080/logout');
        $response = $response->getBody()->getContents();
        $temp = json_decode($response, true);
        if ($temp['success']) {
            Session::flush();
        }
        return $response;
    }
}
