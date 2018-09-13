<?php

namespace App\Http\Controllers;

use App\transaccion;
use Illuminate\Http\Request;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Model;

class TransaccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transacciones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transaccion = new transaccion([
        'referencia' => $request->get('reference'),
        'descripcion'=> $request->get('description'),
        'requestid' => null,
        'expiracion'=> date('c', strtotime('+2 days')),
        'userId'=>'1',
        'total'=> $request->get('total')
        ]);

        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $placetopay = new PlacetoPay([
            'login' => '6dd490faf9cb87a9862245da41170ff2',
            'tranKey' => '024h1IlD',
            'url' => 'https://test.placetopay.com/redirection',
        ]);

        $reference = $transaccion->referencia;
        print_r($reference);
        $request = [
            'payment' => [
                'reference' => $reference,
                'description' => $transaccion->descripcion,
                'amount' => [
                    'currency' => 'COP',
                    'total' => $transaccion->total,
                ],
            ],
            'expiration' => $transaccion->expiracion,
            'returnUrl' => 'http://localhost/redireccionphplibreria/public/returnURL/' . $reference,
            'ipAddress' => $ip,
            'userAgent' => $user_agent,
        ];
        $response = $placetopay->request($request);
        $transaccion->requestid = $response->requestId;
        $transaccion->save();
        if ($response->isSuccessful()) {
            // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
            // Redirect the client to the processUrl or display it on the JS extension
            print_r($response->processUrl());
            return Redirect::to($response->processUrl());
        } else {
            // There was some error so check the message and log it
            $response->status()->message();
        }
          
    }

    public function returnURL(string $referencia)
    {
        $transaccion = Transaccion::where('referencia', $referencia)->first();
        print_r($transaccion);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\transaccion  $transaccion
     * @return \Illuminate\Http\Response
     */
    public function show(transaccion $transaccion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\transaccion  $transaccion
     * @return \Illuminate\Http\Response
     */
    public function edit(transaccion $transaccion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\transaccion  $transaccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transaccion $transaccion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\transaccion  $transaccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(transaccion $transaccion)
    {
        //
    }
}
