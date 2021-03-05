<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::get();

        return view('orders.index', ['orders' => $orders]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => ['required'],
            'customer_email' => ['required', 'email:rfc,dns'],
            'customer_mobile' => ['required'],
        ]);

        $order = new Order($request->all());
        $order->status = 'CREATED';
        $order->save();          
        $idOrder = $order->id;
        
        return redirect()->route('order.show', $idOrder);  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $idOrder)
    {
        $order = Order::find($idOrder);
     
        if($this->isPending($order)) {
            $pay = new PayController(new Client());
            $response = $pay->getRequestInformation($order->request_id);
        
            $order->status = $response['status'];
            $order->save();    
        }

        return view('orders.detail', ['order' => $order]);
    }

    /**
     * Pay the specified order.
     */
    public function processPayment($idOrder)
    {
        $order = Order::find($idOrder);

        $pay = new PayController(new Client());
        $response = $pay->createRequest($order);

        if(strtoupper($response['status']) == 'FAILED'){
            return view('orders.detail', ['order' => $order]);
        }

        if (!$this->isCreated($order)) {
            return view('orders.detail', ['order' => $order]);
        }

        $order->request_id = $response['requestId'];
        $order->status = 'PENDING';
        $order->save();
        
        return redirect()->to($response['processUrl']);  
    }

    private function isPending(Order $order) {
        return strtoupper($order->status) == "PENDING";
    }

    private function isCreated(Order $order) {
        return strtoupper($order->status) == "CREATED";
    }
}
