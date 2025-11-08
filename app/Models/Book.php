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
        'cover_image',
        'price',
        'format',
        'pages',
        'dimensions',
        'language',
        'publisher',
        'author_info',
        'category',
        'category_id',
        'tags',
    ];

    public function getCoverUrlAttribute()
    {
        if (!$this->cover_image) {
            return asset('storage/cover_images/default-book.jpg');
        }
        
        try {
            $disk = \Illuminate\Support\Facades\Storage::disk('public');
            $path = 'cover_images/' . $this->cover_image;
            
            if ($disk->exists($path)) {
                return asset('storage/' . $path);
            } else {
                return asset('storage/cover_images/default-book.jpg');
            }
        } catch (\Throwable $e) {
            return asset('storage/cover_images/default-book.jpg');
        }
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
