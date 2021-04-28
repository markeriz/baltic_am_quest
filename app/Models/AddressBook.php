<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'telephone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address_book_shares()
    {
        return $this->hasMany(AddressBookShare::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }
}
