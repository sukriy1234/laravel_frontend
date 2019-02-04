<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {
        $headers = [
             'Content-Type' => 'application/json',
             'api_token' =>  Session::get('api_token'),
             'Authorization' => 'Bearer token',
         ];
        $client = new \GuzzleHttp\Client([ 'headers' => $headers ]);
        $response = $client->request('POST', 'http://localhost:8080/product');
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function view(Request $request)
    {
        $headers = [
           'Content-Type' => 'application/json',
           'api_token' =>  Session::get('api_token'),
           'Authorization' => 'Bearer token',
      ];
        $client = new \GuzzleHttp\Client([ 'headers' => $headers ]);
        $response = $client->request('POST', 'http://localhost:8080/product', [
           'form_params' => [
               'id' => $request->id
           ]
        ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function update(Request $request)
    {
        $headers = [
           'Content-Type' => 'application/json',
           'api_token' =>  Session::get('api_token'),
           'Authorization' => 'Bearer token',
      ];
        $client = new \GuzzleHttp\Client([ 'headers' => $headers ]);
        $response = $client->request('POST', 'http://localhost:8080/product/update', [
           'form_params' => [
               'id' => $request->id,
               'name' => $request->name,
               'link' => $request->link
           ]
        ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function delete(Request $request)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'api_token' =>  Session::get('api_token'),
            'Authorization' => 'Bearer token',
        ];
        $client = new \GuzzleHttp\Client([ 'headers' => $headers ]);
        $response = $client->request('POST', 'http://localhost:8080/product/delete', [
            'form_params' => [
                'id' => $request->id
             ]
         ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function store(Request $request)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'api_token' =>  Session::get('api_token'),
            'Authorization' => 'Bearer token',
        ];
        $client = new \GuzzleHttp\Client([ 'headers' => $headers ]);
        $response = $client->request('POST', 'http://localhost:8080/product/store', [
            'form_params' => [
                'name' => $request->name,
                'link' => $request->link
             ]
         ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function search(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'http://localhost:8080/product/search', [
            'form_params' => [
                'name' => $request->name
             ]
         ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
}
