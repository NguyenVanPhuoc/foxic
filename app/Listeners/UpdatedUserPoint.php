<?php
namespace App\Listeners;
use App\Events\UpdateUserPoint;

class UpdatedUserPoint {
    /**
     * Handle the event.
     *
     * @param  App\Events\UpdateUserPoint  $event
     * @return void
     */
    public function handle(UpdateUserPoint $event) {
    	if($event->user->point + $event->point >= 0) $event->user->updatePoint($event->point);
    }
}