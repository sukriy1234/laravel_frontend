<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends MainController
{
    public function index()
    {
        $response = parent::config()->request('POST', config('app.url_api').'order');
        $response = $response->getBody()->getContents();
        $temp = json_decode($response, true);
        $temp['session'] = Session::all();
        return $temp;
    }
    public function view(Request $request)
    {
        $response = parent::config()->request('POST', config('app.url_api').'order', [
           'form_params' => [
               'id' => $request->id
           ]
        ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function store(Request $request)
    {
        $response = parent::config()->request('POST', config('app.url_api').'order/store', [
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
        $response = parent::config()->request('POST', config('app.url_api').'order/update', [
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
        $response = parent::config()->request('POST', config('app.url_api').'order/delete', [
            'form_params' => [
                'id' => $request->id
             ]
         ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function reporter(Request $request)
    {
        $response = parent::config()->request('POST', config('app.url_api').'order/reporter', [
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
        $response = parent::config()->request('POST', config('app.url_api').'order/update_finance', [
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
