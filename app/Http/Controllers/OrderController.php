<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'api_token' =>  Session::get('api_token'),
            'Authorization' => 'Bearer token',
        ];
        $client = new \GuzzleHttp\Client([ 'headers' => $headers ]);
        $response = $client->request('POST', 'http://localhost:8080/order');
        $response = $response->getBody()->getContents();
        $temp = json_decode($response, true);
        $temp['session'] = Session::all();
        return $temp;
    }
    public function view(Request $request)
    {
        $headers = [
           'Content-Type' => 'application/json',
           'api_token' =>  Session::get('api_token'),
           'Authorization' => 'Bearer token',
      ];
        $client = new \GuzzleHttp\Client([ 'headers' => $headers ]);
        $response = $client->request('POST', 'http://localhost:8080/order', [
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
        $response = $client->request('POST', 'http://localhost:8080/order/store', [
          'form_params' => [
             'duedate' => date('Y-m-d', strtotime($request->duedate)),
             'reporter' => $request->reporter,
             'product' => $request->product,
             'concierge_fee' => $request->concierge_fee
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
        $response = $client->request('POST', 'http://localhost:8080/order/update', [
          'form_params' => [
             'id' => $request->id,
             'duedate' => date('Y-m-d', strtotime($request->duedate)),
             'reporter' => $request->reporter,
             'product' => $request->product,
             'concierge_fee' => $request->concierge_fee
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
        $response = $client->request('POST', 'http://localhost:8080/order/delete', [
            'form_params' => [
                'id' => $request->id
             ]
         ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function reporter(Request $request)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'api_token' =>  Session::get('api_token'),
            'Authorization' => 'Bearer token',
        ];
        $client = new \GuzzleHttp\Client([ 'headers' => $headers ]);
        $response = $client->request('POST', 'http://localhost:8080/order/reporter', [
            'form_params' => [
                'id' => $request->id,
                'flag' => $request->flag
             ]
         ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function update_finance(Request $request)
    {
        $headers = [
         'Content-Type' => 'application/json',
         'api_token' =>  Session::get('api_token'),
         'Authorization' => 'Bearer token',
      ];
        $client = new \GuzzleHttp\Client([ 'headers' => $headers ]);
        $response = $client->request('POST', 'http://localhost:8080/order/update_finance', [
         'form_params' => [
           'id' => $request->id,
           'payment' => $request->payment,
           'product' => $request->product,
           'concierge_fee' => $request->concierge_fee
           ]
      ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
}
