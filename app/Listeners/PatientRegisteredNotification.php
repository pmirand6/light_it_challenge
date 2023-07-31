<?php

namespace App\Listeners;

use App\Events\PatientCreated;
use App\Notifications\PatientRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PatientRegisteredNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private readonly PatientRegistered $notification)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @throws \ReflectionException
     */
    public function handle(PatientCreated $event): void
    {
        //
        $patient = $event->patientModel;
        $this->notification->sendNotification($patient->toArray());
    }
}
