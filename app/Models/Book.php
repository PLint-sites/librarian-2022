<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $appends = ['start_reading_date'];

    protected $casts = [
        'start_reading' => 'datetime:Y-m-d',
        'finish_reading' => 'datetime:Y-m-d',
    ];

    /**
     * Get the user that owns the book.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the writer that owns the book.
     */
    public function writer()
    {
        return $this->belongsTo(Writer::class);
    }

    /**
     * Get the genre that owns the book.
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Scope: only include books from authenticated user
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMybooks($query)
    {
        return $query->where('user_id', \Auth::id());
    }

    /**
     * Scope: only include books from authenticated user that are on the bookshelf
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBookshelf($query)
    {
        return $query->where(['user_id' => \Auth::id(), 'is_on_bookshelf' => 1]);
    }

    /**
     * Get the date you started reading for humans
     *
     * @return string
     */
    public function getStartReadingDateAttribute()
    {
        if (!is_null($this->start_reading)) {
            return $this->start_reading->diffForHumans();
        }
        return null;
    }

}
