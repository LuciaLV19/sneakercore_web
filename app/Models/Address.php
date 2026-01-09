<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'address_line',
        'city',
        'postal_code',
        'country',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
