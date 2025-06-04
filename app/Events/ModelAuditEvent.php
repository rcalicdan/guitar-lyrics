<?php

namespace App\Events;

class ModelAuditEvent
{
    public $model;
    public $event;
    public $oldValues;
    public $newValues;
    public $metadata;

    public function __construct($model, string $event, array $oldValues = [], array $newValues = [], array $metadata = [])
    {
        $this->model = $model;
        $this->event = $event;
        $this->oldValues = $oldValues;
        $this->newValues = $newValues;
        $this->metadata = $metadata;
    }
}