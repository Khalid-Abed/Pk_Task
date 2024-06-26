@extends('layouts.app')

@section('content')
<div class="container">
<table id="cart" class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Price</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0 @endphp
        @if(session('cart'))
            @foreach(session('cart') as $id => $item)

                <tr rowId="{{ $id }}">
                    <td data-th="Title">
                        <div class="row">
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $item['title'] }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">${{ $item['price'] }}</td>

                    <td data-th="Subtotal" class="text-center">${{ $item['price'] * $item['quantity'] }}</td>
                    <td class="actions">
                        <a class="btn btn-outline-danger btn-sm delete-item">Delete</a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right p-3">
                <a class="btn btn-danger" href="{{ route('getCheckoutForm')}}">Checkout</a>
            </td>
        </tr>
    </tfoot>
</table>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
  $(document).ready(function(){
        $(".delete-item").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            if(confirm("Do you really want to delete?")) {
                $.ajax({
                    url: "{{ route('delete.cart.item') }}",
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").attr("rowId")
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
   });

</script>
@endsection
