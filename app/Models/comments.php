<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;
    protected $fillable=[
        'post_id',
        'user_id',
        'guest_id',
        'content',
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
