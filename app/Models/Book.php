<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'description',
        'ebook_file',
        'file_format',
        'status',
        'cover_image'
    ];
    // Relationship: A book belongs to multiple schools
    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_books', 'book_id', 'school_id')->withTimestamps();
    }

    // Relationship: A book has many chapters
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
