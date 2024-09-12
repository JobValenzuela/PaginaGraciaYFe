<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MedicEvent implements ShouldBroadcastNow // Implementar ShouldBroadcast para transmisiones
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;  // Aquí defines los datos que enviarás a Pusher
    }

    // Define el canal en el que quieres emitir
    public function broadcastOn()
    {
        return new Channel('Medic-channel');
    }

    // Define el nombre del evento (cambiarlo a algo relacionado con el evento)
    public function broadcastAs()
    {
        return 'MedicEvent'; // Nombre del evento, no del canal
    }
}
