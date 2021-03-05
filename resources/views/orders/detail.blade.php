@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <h2 class="card-header">Detalle de la orden #{{ $order->id }}</h2>
            <!--<<h5 class="card-header">Pedido el {{ $order->created_at }}</h5>-->
            <div class="card-body">
                <h5 class="card-header">Resumen</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item">Producto: <span>GENERAL</span></li>
                    <li class="list-group-item">Cantidad: <span>1000</span></li>
                </ul>
                <h5 class="card-header">Datos Comprador</h5>
                <ul class="list-group">
                    <li class="list-group-item">{{ $order->customer_name }}</li>
                    <li class="list-group-item">{{ $order->customer_email }}</li>
                    <li class="list-group-item">{{ $order->customer_mobile }}</li>
                </ul>
                @if ($order->status == 'CREATED')
                    <a href="{{ route('order.pay', $order->id) }}" class="btn btn-primary text-white mt-4">Pagar</a>
                @elseif ($order->status == 'REJECTED')
                    <p class="card-header alert bg-danger text-white mt-4">Pago Rechazado </p>
                    
                @elseif ($order->status == 'PENDING')
                    <p class="card-header alert bg-warning text-white mt-4">Pago Pendiente de Aprobación</p>
                @else
                    <p class="card-header alert bg-success text-white mt-4">Pago exitoso</p>
                @endif

                <a href="{{ route('order.index') }}" class="btn btn-info text-white mt-4">Volver</a>
                
            </div>
            
        </div>
    </div>
@endsection
