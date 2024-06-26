@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Checkout</h1>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['price'] * $details['quantity']; @endphp
                    <tr>
                        <td>{{ $details['title'] }}</td>
                        <td>${{ $details['price'] }}</td>
                        <td>{{ $details['quantity'] }}</td>
                        <td>${{ $details['price'] * $details['quantity'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Total: ${{ $total }}</h3>

        <form action="{{ route('cart.checkout') }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-primary">Confirm Checkout</button>
        </form>
    </div>
@endsection
