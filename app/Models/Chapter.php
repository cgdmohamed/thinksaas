<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'content',
        'book_id'
    ];

    // Relationship: A chapter belongs to a book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
