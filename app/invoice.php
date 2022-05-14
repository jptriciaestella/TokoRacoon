<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    protected $fillable = [
        'user_id','postal_code','address','tax','total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsToMany(product::class)->withPivot('quantity');
    }
}
