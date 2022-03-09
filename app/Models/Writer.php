<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Writer extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the books for the writer.
     */
    public function books()
    {
        // return $this->hasMany(Book::class, 'writer_id', 'identifier');
        return $this->hasMany(Book::class);
    }

    /**
     * Get the user that owns the writer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: only include writers from authenticated user
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMywriters($query)
    {
        return $query->where('user_id', \Auth::id());
    }
}
