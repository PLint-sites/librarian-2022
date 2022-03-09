<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Http\Requests\SaveWriterRequest;

use App\Models\Writer;

use Redirect;
use Auth;

class WritersController extends Controller
{
    public function index()
    {
        $writers = Writer::with('books')->mywriters()->latest()->get();

        return Inertia::render('Writers', compact('writers'));
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
}
