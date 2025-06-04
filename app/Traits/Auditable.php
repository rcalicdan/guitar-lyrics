<?php
// app/Traits/Auditable.php

namespace App\Traits;

use App\Models\AuditLog;
use CodeIgniter\HTTP\RequestInterface;

trait Auditable
{
    protected static $auditEvents = ['created', 'updated', 'deleted'];
    
    public function initializeAuditable()
    {
        $this->addObservableEvents(static::$auditEvents);
        
        foreach (static::$auditEvents as $event) {
            static::registerModelEvent($event, function ($model) use ($event) {
                $model->logAudit($event);
            });
        }
    }

    protected function logAudit(string $event)
    {
        $oldValues = [];
        $newValues = [];

        switch ($event) {
            case 'created':
                $newValues = $this->getAttributes();
                break;
            case 'updated':
                $oldValues = $this->getOriginal();
                $newValues = $this->getDirty();
                break;
            case 'deleted':
                $oldValues = $this->getOriginal();
                break;
        }

        AuditLog::create([
            'auditable_type' => get_class($this),
            'auditable_id' => $this->getKey(),
            'event' => $event,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'user_id' => $this->getCurrentUserId(),
            'ip_address' => $this->getClientIpAddress(),
            'user_agent' => $this->getUserAgent(),
        ]);
    }

    protected function getCurrentUserId()
    {
        $session = session();
        return $session->get('auth_user_id') ?? null;
    }

    protected function getClientIpAddress()
    {
        $request = service('request');
        return $request->getIPAddress();
    }

    protected function getUserAgent()
    {
        $request = service('request');
        return $request->getUserAgent()->getAgentString();
    }
}