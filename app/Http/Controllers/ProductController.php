<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends MainController
{
    public function index()
    {
        $response = parent::config()->request('POST', config('app.url_api').'product');
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function view(Request $request)
    {
        $response = parent::config()->request('POST', config('app.url_api').'product', [
           'form_params' => [
               'id' => $request->id
           ]
        ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function update(Request $request)
    {
        $response = parent::config()->request('POST', config('app.url_api').'product/update', [
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
        $response = parent::config()->request('POST', config('app.url_api').'product/delete', [
            'form_params' => [
                'id' => $request->id
             ]
         ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function store(Request $request)
    {
        $response = parent::config()->request('POST', config('app.url_api').'product/store', [
            'form_params' => [
                'name' => $request->name,
                'link' => $request->link
             ]
         ]);
        $response = $response->getBody()->getContents();
        return $response;
    }
    public function search()
    {
        $response = parent::config()->request('GET', config('app.url_api').'product/search');
        $response = $response->getBody()->getContents();
        return $response;
    }
}
