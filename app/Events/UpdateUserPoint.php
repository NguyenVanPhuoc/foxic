<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UpdateUserPoint {
    use SerializesModels;

    /**
     * The User.
     *
     * @var App\Models\User
     */
    public $user;
    public $point;

    /**
     * Create a new event instance.
     *
     * @param  App\Models\User $user
     * @return void
     */
    public function __construct($user, $point) {
        $this->user = $user;
        $this->point = $point;
    }
}
