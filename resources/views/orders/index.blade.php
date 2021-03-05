@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pb-4">
            <h2 class="col">Ordenes</h2>
            <div class="col"></div>
            <div class="col col-lg-2"><a href="{{ route('order.create') }}" class="col btn btn-primary text-white mt-4">Crear Orden</a></div>
        </div>    
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col"># Orden</th>
                    <th scope="col">Fecha Solicitud</th>
                    <th scope="col">Nombre Cliente</th>
                    <th scope="col">Email Cliente</th>
                    <th scope="col">Teléfono Movil Cliente</th>
                    <th scope="col">Estado Orden</th>
                    <th scope="col">Fecha Actualización de estado</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_email }}</td>
                        <td>{{ $order->customer_mobile }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td>
                            <div class="card-body col-md-2">
                                <div class="dropdown show">
                                    <a class="btn btn-secondary dropdown-toggle options-item" href="#" role="button"
                                        id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Opciones
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item"
                                            href="{{ route('order.show', $order->id) }}">Detalle</a>
                                           
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <th scope="row"></th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
