<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['selected_concessions', 'send_to_kitchen_time', 'status'];

    // Cast selected_concessions to array for easier manipulation
    protected $casts = [
        'selected_concessions' => 'array',
    ];

    public function concessions()
    {
        return $this->belongsToMany(Concession::class, 'order_concession')
                    ->withPivot('quantity') 
                    ->withTimestamps();
    }

}