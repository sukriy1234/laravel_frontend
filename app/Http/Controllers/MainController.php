<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    protected $main_url;

    public function __construct()
    {
        $this->main_url = config('app.url_api');
    }

    // public function client()
    public function client($type, $url, $param)
    {
        if (Session::get('login')) {
            $headers = [
                'Content-Type' => 'application/json',
                'api_token' => Session::get('api_token'),
                'Authorization' => 'Bearer token',
            ];
            $client = new \GuzzleHttp\Client(['headers' => $headers]);
        } else {
            $client = new \GuzzleHttp\Client();
        }
        //send request to api
        $response = $client->request($type, $url, [
            'form_params' => $param,
        ]);

        return $response->getBody()->getContents();
    }

    public function config()
    {
        if (Session::get('login')) {
            $headers = [
                'Content-Type' => 'application/json',
                'api_token' => Session::get('api_token'),
                'Authorization' => 'Bearer token',
            ];
            $client = new \GuzzleHttp\Client(['headers' => $headers]);
        } else {
            $client = new \GuzzleHttp\Client();
        }

        return $client;
    }
}
