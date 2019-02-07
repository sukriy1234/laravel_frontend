<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends MainController
{
    public function coba()
    {
        var_dump(config('app.url_api'));
    }

    public function index()
    {
        if (Session::get('login')) {
            return view('home');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $type = 'POST';
        $url = $this->main_url.'login';
        $param = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        $response = $this->client($type, $url, $param);

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
        $type = 'GET';
        $url = $this->main_url.'user/search';
        $param = [];
        $response = $this->client($type, $url, $param);

        return $response;
    }

    public function logout()
    {
        $type = 'POST';
        $url = $this->main_url.'logout';
        $param = [];
        $response = $this->client($type, $url, $param);
        Session::flush();

        return $response;
    }
}
