@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Completa el formulario para realizar la compra</h2>
        <div class="order-form container" style="color: #4c4c4c;padding: 20px;box-shadow: 0 0 10px 0 rgba(0, 0, 0, .1);">
            <form class="form-home" action="/order" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="inputCustomerName">Nombre Completo</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name') }}"
                        placeholder="Nombre Completo">
                </div>
                <div class="form-group">
                    <label for="inputCustomerEmal">Correo Electrónico</label>
                    <input type="text" class="form-control" id="customer_email" name="customer_email" value="{{ old('customer_email') }}"
                        placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="inputCustomerMobile">Teléfono</label>
                    <input type="number" class="form-control" id="customer_mobile" name="customer_mobile" value="{{ old('customer_mobile') }}"
                        placeholder="Teléfono">
                </div>
                <button type="submit" class="btn btn-primary">Continuar</button>
                <a href="{{ route('order.index') }}" class="btn btn-info text-white">Volver</a>
            </form>
        </div>
    </div>
@endsection
