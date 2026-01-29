<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Http\Requests\SaveWriterRequest;
use App\Http\Requests\SaveBookForWriterRequest;

use App\Models\Writer;
use App\Models\Book;

use Redirect;
use Auth;
use Carbon\Carbon;

class WritersController extends Controller
{
    public function index()
    {
        $writers = Writer::with('books')->mywriters()->latest()->get();
        $genres = \App\Models\Genre::all();

        return Inertia::render('Writers', compact('writers', 'genres'));
    }

    /**
     * Store a new writer in the database
     *
     * @param SaveWriterRequest $request
     * @return void
     */
    public function store(SaveWriterRequest $request)
    {
        $request->merge(['user_id' => Auth::ID()]);
        Writer::create($request->all());

        return Redirect::route('writers');
    }

    /**
     * Update existing writer
     *
     * @param SaveWriterRequest $request
     * @return void
     */
    public function update(SaveWriterRequest $request, Writer $writer)
    {
        $writer->update($request->all());

        return Redirect::route('writers');
    }

    public function delete(Writer $writer)
    {
        $writer->delete();

        return Redirect::route('writers');
    }

    /**
     * Store a new book for a specific writer
     *
     * @param SaveBookForWriterRequest $request
     * @param Writer $writer
     * @return void
     */
    public function storeBookForWriter(SaveBookForWriterRequest $request, Writer $writer)
    {
        $request->merge(['user_id' => Auth::ID(), 'writer_id' => $writer->id]);

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

        return Redirect::route('writers');
    }
}
