<?php

namespace App\Listeners;

use App\Models\AuditLog;
use App\Events\ModelAuditEvent;
use CodeIgniter\HTTP\IncomingRequest;

class AuditLogListener
{
    protected $request;

    public function __construct()
    {
        $this->request = service('request');
    }

    /**
     * Handle model audit events
     */
    public function handleModelAudit(ModelAuditEvent $event)
    {
        $this->createAuditLog(
            $event->model,
            $event->event,
            $event->oldValues,
            $event->newValues,
            $event->metadata
        );
    }

    /**
     * Create audit log entry
     */
    protected function createAuditLog($model, string $eventType, array $oldValues = [], array $newValues = [], array $metadata = [])
    {
        // Get current user information
        $user = $this->getCurrentUser();
        
        // Calculate changes for update events
        $changes = [];
        if ($eventType === 'updated') {
            $changes = $this->getModelChanges($oldValues, $newValues);
        }

        AuditLog::create([
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
            'event' => $eventType,
            'old_values' => $eventType === 'created' ? null : $oldValues,
            'new_values' => $eventType === 'deleted' ? null : $newValues,
            'changes' => empty($changes) ? null : $changes,
            'user_id' => $user ? $user->id : null,
            'user_type' => $user ? get_class($user) : null,
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'metadata' => empty($metadata) ? null : $metadata,
        ]);
    }

    /**
     * Get the current authenticated user
     */
    protected function getCurrentUser()
    {
        $session = session();
        $userId = $session->get('auth_user_id');
        
        if ($userId) {
            return \App\Models\User::find($userId);
        }
        
        return null;
    }

    /**
     * Calculate the changes between old and new values
     */
    protected function getModelChanges(array $oldValues, array $newValues): array
    {
        $changes = [];
        
        foreach ($newValues as $key => $newValue) {
            $oldValue = $oldValues[$key] ?? null;
            
            if ($oldValue != $newValue) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $newValue,
                ];
            }
        }
        
        return $changes;
    }

    /**
     * Handle pivot attach events
     */
    public function handlePivotAttach($data)
    {
        $this->createAuditLog(
            $data['parent_model'],
            'pivot_attached',
            [],
            $data['pivot_data'],
            [
                'relation' => $data['relation'],
                'related_model' => $data['related_model'],
                'related_id' => $data['related_id'],
            ]
        );
    }

    /**
     * Handle pivot detach events
     */
    public function handlePivotDetach($data)
    {
        $this->createAuditLog(
            $data['parent_model'],
            'pivot_detached',
            $data['pivot_data'],
            [],
            [
                'relation' => $data['relation'],
                'related_model' => $data['related_model'],
                'related_id' => $data['related_id'],
            ]
        );
    }

    /**
     * Handle pivot update events
     */
    public function handlePivotUpdate($data)
    {
        $this->createAuditLog(
            $data['parent_model'],
            'pivot_updated',
            $data['old_data'],
            $data['new_data'],
            [
                'relation' => $data['relation'],
                'related_model' => $data['related_model'],
                'related_id' => $data['related_id'],
            ]
        );
    }
}