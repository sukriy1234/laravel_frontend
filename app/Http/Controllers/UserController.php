<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends MainController
{
    public function __construct()
    {
    }
    public function coba()
    {
        var_dump(config('app.url_api'));
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
        $response = parent::config()->request('POST', config('app.url_api').'login', [
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
    public function search()
    {
        $response = parent::config()->request('GET', config('app.url_api').'user/search');
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function logout()
    {
        $response = parent::config()->request('POST', config('app.url_api').'logout');
        $response = $response->getBody()->getContents();
        Session::flush();
        return $response;
    }
}
