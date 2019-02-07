<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends MainController
{
    public function index()
    {
        $type = 'POST';
        $url = $this->main_url.'order';
        $param = [];
        $response = $this->client($type, $url, $param);

        $temp = json_decode($response, true);
        $temp['session'] = Session::all();

        return $temp;
    }

    public function view(Request $request)
    {
        $type = 'POST';
        $url = $this->main_url.'order';
        $param = [
            'id' => $request->id,
        ];
        $response = $this->client($type, $url, $param);

        return $response;
    }

    public function store(Request $request)
    {
        $type = 'POST';
        $url = $this->main_url.'order/store';
        $param = [
            'duedate' => date('Y-m-d', strtotime($request->duedate)),
            'reporter' => $request->reporter,
            'product' => $request->product,
            'concierge_fee' => $request->concierge_fee,
        ];
        $response = $this->client($type, $url, $param);

        return $response;
    }

    public function update(Request $request)
    {
        $type = 'POST';
        $url = $this->main_url.'order/update';
        $param = [
            'id' => $request->id,
            'duedate' => date('Y-m-d', strtotime($request->duedate)),
            'reporter' => $request->reporter,
            'product' => $request->product,
            'concierge_fee' => $request->concierge_fee,
        ];
        $response = $this->client($type, $url, $param);

        return $response;
    }

    public function delete(Request $request)
    {
        $type = 'POST';
        $url = $this->main_url.'order/delete';
        $param = [
            'id' => $request->id,
        ];
        $response = $this->client($type, $url, $param);

        return $response;
    }

    public function reporter(Request $request)
    {
        $type = 'POST';
        $url = $this->main_url.'order/reporter';
        $param = [
            'id' => $request->id,
            'flag' => $request->flag,
        ];
        $response = $this->client($type, $url, $param);

        return $response;
    }

    public function update_finance(Request $request)
    {
        $type = 'POST';
        $url = $this->main_url.'order/update_finance';
        $param = [
            'id' => $request->id,
            'payment' => $request->payment,
            'product' => $request->product,
            'concierge_fee' => $request->concierge_fee,
        ];
        $response = $this->client($type, $url, $param);

        return $response;
    }
}
