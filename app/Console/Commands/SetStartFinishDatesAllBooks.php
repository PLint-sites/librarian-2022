<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Book;

class SetStartFinishDatesAllBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:start-finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets a value for start_reading and finished_reading for all books in the system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $allBooks = Book::all();
        $books = Book::where('completed', 1)->get();
        
        foreach ($books as $book) {
            $book->start_reading = $book->created_at;
            $book->finish_reading = $book->updated_at;
            $book->save();
        }
    }
}
