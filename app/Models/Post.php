<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable=['worker_id','content','price','image','rejected_reason'];



    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    
    public function worker(){
        return $this->belongsTo('App\Models\Worker','worker_id');
    }
}
