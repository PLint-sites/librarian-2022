<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Http\Requests\SaveBookAndWriterRequest;

use App\Models\Genre;
use App\Models\Writer;
use App\Models\Book;

use Auth;
use Redirect;

class BoardingController extends Controller
{
    /**
     * User arrives here after registration, only once
     *
     * @return void
     */
    public function addYourFirstBook()
    {
        if (Auth::user()->is_onboarded == 1) {
            return Redirect::route('books');
        }
        
        $genres = Genre::all();
        return Inertia::render('AddYourFirstBook', compact('genres'));
    }

    public function storeBookAndWriter(SaveBookAndWriterRequest $request)
    {
        $writer = Writer::create([
            'name' => $request->writer,
            'user_id' => Auth::ID(),
        ]);

        Book::create([
            'title' => $request->title,
            'owned' => $request->owned,
            'completed' => $request->completed,
            'genre_id' => $request->genre_id,
            'writer_id' => $writer->id,
            'user_id' => Auth::ID(),
        ]);

        // Update onboarding attribute for the user
        Auth::user()->is_onboarded = 1;
        Auth::user()->save();

        return Redirect::route('books');
    }
}
