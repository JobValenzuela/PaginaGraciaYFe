<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TriageEvent implements ShouldBroadcastNow // Implementar ShouldBroadcast para transmisiones
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;  // Aquí defines los datos que enviarás a Pusher
    }

    public function broadcastOn()
    {
        return new Channel('triage-channel'); // Define el canal en el que quieres emitir
    }

    public function broadcastAs()
    {
        return 'triage-channel'; // Define el nombre del evento
    }
}
