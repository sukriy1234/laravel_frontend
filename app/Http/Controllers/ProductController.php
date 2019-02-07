<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends MainController
{
    public function index()
    {
        $type = 'POST';
        $url = $this->main_url.'product';
        $param = [];
        $response = $this->client($type, $url, $param);

        return $response;
    }

    public function view(Request $request)
    {
        $type = 'POST';
        $url = $this->main_url.'product';
        $param = [
            'id' => $request->id,
        ];
        $response = $this->client($type, $url, $param);

        return $response;
    }

    public function update(Request $request)
    {
        $type = 'POST';
        $url = $this->main_url.'product/update';
        $param = [
            'id' => $request->id,
            'name' => $request->name,
            'link' => $request->link,
        ];
        $response = $this->client($type, $url, $param);

        return $response;
    }

    public function delete(Request $request)
    {
        $type = 'POST';
        $url = $this->main_url.'product/delete';
        $param = [
            'id' => $request->id,
        ];
        $response = $this->client($type, $url, $param);

        return $response;
    }

    public function store(Request $request)
    {
        $type = 'POST';
        $url = $this->main_url.'product/store';
        $param = [
            'name' => $request->name,
            'link' => $request->link,
        ];
        $response = $this->client($type, $url, $param);

        return $response;
    }

    public function search()
    {
        $type = 'GET';
        $url = $this->main_url.'product/search';
        $param = [];
        $response = $this->client($type, $url, $param);

        return $response;
    }
}
