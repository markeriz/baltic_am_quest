<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressBookShare extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'address_book_id',
        'user_id',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address_book()
    {
        return $this->belongsTo(AddressBook::class);
    }
}
