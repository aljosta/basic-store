<?php

namespace App\Http\Controllers;
 
use Exception;
use Illuminate\Http\Request;
use Src\Order\Application\CreateOrderUseCase;
use Src\Order\Application\FindOrderUseCase;
use Src\Order\Application\GetAllOrdersUseCase;
use Src\Order\Application\GetOrderPaymentUseCase;
use Src\Order\Application\ProcessOrderPaymentUseCase;
use Src\Order\Infrastructure\EloquentOrderRepository;
use Src\Order\Infrastructure\PlaceToPayService;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getAllOrdersUseCase = new GetAllOrdersUseCase(new EloquentOrderRepository());
        $dataOrders = $getAllOrdersUseCase->execute();
        return view('orders.index', ['orders' => $dataOrders]);
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

        $eloquent = new EloquentOrderRepository();
        $createOrder = new CreateOrderUseCase($eloquent);
        
        $createOrder->execute(
            $request->customer_name,
            $request->customer_email,
            $request->customer_mobile,
            "CREATED"
        );
        
        $idOrder = $eloquent->getSaveId();
        return redirect()->route('order.show', $idOrder);  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $orderId)
    {
        $getOrderPayment = new GetOrderPaymentUseCase(new PlaceToPayService(), new EloquentOrderRepository());
        $order = $getOrderPayment->execute($orderId);

        return view('orders.detail', ['order' => $order]);
    }

    /**
     * Pay the specified order.
     */
    public function processPayment($orderId)
    {
        try {
            $processPayment = new ProcessOrderPaymentUseCase(new PlaceToPayService, new EloquentOrderRepository);
            $processUrl = $processPayment->execute($orderId);
        } catch (Exception $exception) {
            $findOrder = new FindOrderUseCase(new EloquentOrderRepository);
            $dataOrder = $findOrder->execute($orderId);
            return view('orders.detail', ['order' => $dataOrder]);
        }
        
        return redirect()->to($processUrl);  
    }
}
