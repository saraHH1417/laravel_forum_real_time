<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'title',
        'slug' ,
        'body',
        'category_id',
        'user_id'
    ];

//    protected $guarded = [];

    protected static function boot(){
        parent::boot();

        static::creating(function ($question){
            $question->slug = Str::slug($question->title);
        });

        static::updating(function ($question){
            $question->slug = Str::slug($question->title);
        });

    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPathAttribute()
    {
        return "questions/$this->slug";
    }
}
