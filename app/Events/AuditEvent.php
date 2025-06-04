<?php

namespace App\Events;

use CodeIgniter\Events\Events;

class AuditEvent
{
    public static function trigger(string $eventName, array $data)
    {
        Events::trigger($eventName, $data);
    }
}