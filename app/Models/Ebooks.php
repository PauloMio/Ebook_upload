<?php

// app/Models/Ebook.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ebooks extends Model
{
    protected $fillable = [
        'title',
        'description',
        'author',
        'category',
        'edition',
        'publisher',
        'copyrightyear',
        'location',
        'class',
        'subject',
        'doi',
        'pdf',
        'coverage',
    ];
}
