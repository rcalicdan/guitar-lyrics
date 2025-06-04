<?php

namespace App\Traits;

use CodeIgniter\Events\Events;
use App\Events\ModelAuditEvent;

trait Auditable
{
    protected static function bootAuditable()
    {
        // Listen to created event
        static::created(function ($model) {
            $event = new ModelAuditEvent(
                $model,
                'created',
                [],
                $model->getAttributes(),
                $model->getAuditMetadata()
            );
            Events::trigger('model_audit', $event);
        });

        // Listen to updated event
        static::updated(function ($model) {
            $event = new ModelAuditEvent(
                $model,
                'updated',
                $model->getOriginal(),
                $model->getAttributes(),
                $model->getAuditMetadata()
            );
            Events::trigger('model_audit', $event);
        });

        // Listen to deleted event
        static::deleted(function ($model) {
            $event = new ModelAuditEvent(
                $model,
                'deleted',
                $model->getAttributes(),
                [],
                $model->getAuditMetadata()
            );
            Events::trigger('model_audit', $event);
        });
    }

    /**
     * Get additional metadata for the audit log
     * Override this method in your models to add custom metadata
     */
    protected function getAuditMetadata(): array
    {
        return [];
    }

    /**
     * Get audit logs for this model
     */
    public function auditLogs()
    {
        return $this->morphMany(\App\Models\AuditLog::class, 'auditable');
    }
}