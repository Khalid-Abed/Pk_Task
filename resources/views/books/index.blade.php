@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Books</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('books.search') }}" method="GET" class="my-5">
        <input type="text" name="query" placeholder="Search for books...">
        <button type="submit">Search</button>
    </form>

    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Add New Book</a>

    <div>
        <a href="{{ route('books.cart') }}" class="btn btn-danger mb-3">Show Cart items</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ Str::limit($book->description, 50) }}</td>
                    <td>${{ $book->price }}</td>
                    <td>{{ $book->quantity }}</td>
                    <td>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm mx-2">Edit</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>

                        <input type="hidden" class="book-quantity" value="1">
                        <button class="btn btn-secondary btn-sm mx-2 add-to-cart" data-book-id="{{ $book->id }}">Add To Cart</button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $books->links() }}
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    $(document).ready(function(){
        $(".add-to-cart").click(function (e) {
            e.preventDefault();
            var bookId = $(this).data("book-id");
            var bookQuantity = $(".book-quantity").val();
            $.ajax({
                url: "{{ route('cart.add') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    bookId: bookId,
                    quantity: bookQuantity,
                },
                success: function (response) {
                    alert('Cart Updated');
                    console.log('book added to cart successfully');
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });
    })

</script>


@endsection
