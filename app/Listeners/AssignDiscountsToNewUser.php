<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class AssignDiscountsToNewUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;
        $user->updateAutomaticDiscounts();
    }
}