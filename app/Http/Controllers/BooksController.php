<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Http\Requests\SaveBookRequest;

use App\Models\Book;
use App\Models\Writer;

use Redirect;
use Auth;
use Carbon\Carbon;

class BooksController extends Controller
{
    public function __construct() {
        $this->perPage = 20;
    }
    /**
     * Load initial set of books and pass them to the Books component
     *
     * @return void
     */
    public function index()
    {
        $books = Book::with('genre', 'writer')->mybooks()->orderBy('start_reading', 'desc');
        $booksCount = $books->count();
        $books = $books->limit($this->perPage)->get();

        $writers = Writer::mywriters()->latest()->get();
        $genres = \App\Models\Genre::all();
        $perPage = $this->perPage;

        return Inertia::render('Books', compact('books', 'booksCount', 'writers', 'genres', 'perPage'));
    }

    /**
     * Draw more books from the database, given an offset $page and possibly a search term $search
     *
     * @param Integer $page
     * @return Array
     */
    public function draw($page, $search = null)
    {
        $books = Book::with('genre', 'writer')->orderBy('start_reading', 'desc');

        // search
        if (!is_null($search)) {
            $books = $books->where('title', 'like', '%' . $search . '%')
                ->orWhereHas('writer', function($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        }

        // keep only mybooks: if we do this before search, the query adds possible books
        // from another user nonetheless
        $books = $books->mybooks();

        $booksCount = $books->count();

        $books = $books->offset($page * $this->perPage)->limit($this->perPage)->get();

        return compact('books', 'booksCount');
    }

    public function bookshelf()
    {
        $books = Book::with('genre', 'writer')->bookshelf()->orderBy('created_at', 'desc')->get();
        $writers = Writer::mywriters()->latest()->get();
        $genres = \App\Models\Genre::all();

        return Inertia::render('Bookshelf', compact('books', 'writers', 'genres'));
    }

    /**
     * Store a new book in the database
     *
     * @param SaveBookRequest $request
     * @return void
     */
    public function store(SaveBookRequest $request)
    {
        $request->merge(['user_id' => Auth::ID()]);

        // Start reading checked => set date, otherwise, put it on the bookshelf
        if ($request->start_reading) {
            $request->merge(['start_reading' => Carbon::now()]);
        } else {
            $request->merge(['start_reading' => null, 'is_on_bookshelf' => 1]);
        }

        // Completed checked => set date start/finish both to now
        if ($request->completed) {
            $request->merge(['start_reading' => Carbon::now(), 'finish_reading' => Carbon::now(), 'is_on_bookshelf' => 0]);
        }

        Book::create($request->all());

        return Redirect::route('books');
    }

    /**
     * Update existing book
     *
     * @param SaveBookRequest $request
     * @return void
     */
    public function update(SaveBookRequest $request, Book $book)
    {
        // if start checkbox selected, set time started
        if ($request->has('start_reading') && $request->start_reading === true) {
            $request->merge(['start_reading' => Carbon::now()]);
        }

        // if completed checkbox was just checked, set time finished, pull from bookshelf
        if ($request->has('completed') && $request->completed && !$book->completed) {
            $request->merge(['finish_reading' => Carbon::now(), 'is_on_bookshelf' => 0]);
        }

        // if completed checkbox was just unchecked, clear finish_reading
        if ($request->has('completed') && !$request->completed && $book->completed) {
            $request->merge(['finish_reading' => null]);
        }

        $book->update($request->all());

        return Redirect::route('books');
    }

    public function delete(Book $book)
    {
        $book->delete();

        return Redirect::route('books');
    }
}
