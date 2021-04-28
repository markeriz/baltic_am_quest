<?php

namespace App\Observers;

use App\Models\AddressBook;

class AddressBookObserver
{
    // Retrieved
    // Creating
    // Created
    // Updating
    // Updated
    // Saving
    // Saved
    // Deleting
    // Deleted
    // Restoring
    // Restored

    public function creating(AddressBook $address_book)
    {
        $address_book->user_id = auth()->user()->id;
    }
}
