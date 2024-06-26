<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(BookRequest $request)
    {
        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->all());
        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $books = Book::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('author', 'LIKE', "%{$query}%")
                    ->paginate(10);
        return view('books.index', compact('books'));
    }

    /**
     * add book to card using session
     */
    public function addToCart(Request $request)
    {
        $bookId = $request->input('bookId');
        $book = Book::find($bookId);

        if (!$book) {
            return redirect()->route('books.index')->with('error', 'book not found!');
        }

        $cart = session()->get('cart', []);
        $cart[$bookId] = [
            'title' => $book->title,
            'price' => $book->price,
            'quantity' => $request->quantity,
        ];
        session()->put('cart', $cart);
        return redirect()->route('books.index')->with('success', 'book added to cart successfully!');
    }

    /**
     * delete book from cart
     */
    public function deleteItem(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'book successfully deleted.');
        }
    }

    /**
     * list cart items => books
     */
    public function bookCart()
    {
        // dd(session()->get('cart'));
        return view('cart.cart');
    }

    /**
     * return form of checkout
     */
    public function getCheckoutForm()
    {
        return view('cart.checkout');
    }

      /**
     * start checkout proccess
     */

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('books.index')->with('error', 'Your cart is empty.');
        }

        // Calculate the total price
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        dd($totalPrice);

    }

}
