<?php

namespace App\Libraries\Audit;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait Auditable
{
    protected static function bootAuditable(): void
    {  
        static::created(function ($model) {
            AuditLogger::created($model);
        });

        static::updated(function ($model) {
            AuditLogger::updated($model);
        });

        static::deleted(function ($model) {
            AuditLogger::deleted($model);
        });
    }

    /**
     * Override attach method to log many-to-many attachments
     */
    public function attach($id, array $attributes = [], $touch = true)
    {
        $relation = $this->getRelationFromBacktrace();

        if ($relation) {
            $result = parent::attach($id, $attributes, $touch);
            AuditLogger::attached($this, $relation, $id, $attributes);
            return $result;
        }

        return parent::attach($id, $attributes, $touch);
    }

    /**
     * Override detach method to log many-to-many detachments
     */
    public function detach($ids = null, $touch = true)
    {
        $relation = $this->getRelationFromBacktrace();

        if ($relation) {
            $result = parent::detach($ids, $touch);
            AuditLogger::detached($this, $relation, $ids);
            return $result;
        }

        return parent::detach($ids, $touch);
    }

    /**
     * Override sync method to log many-to-many sync operations
     */
    public function sync($ids, $detaching = true)
    {
        $relation = $this->getRelationFromBacktrace();

        if ($relation) {
            $changes = parent::sync($ids, $detaching);
            AuditLogger::synced($this, $relation, $changes);
            return $changes;
        }

        return parent::sync($ids, $detaching);
    }

    /**
     * Get the relation name from backtrace
     */
    protected function getRelationFromBacktrace(): ?string
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10);

        foreach ($trace as $frame) {
            if (isset($frame['object']) && $frame['object'] instanceof BelongsToMany) {
                return $frame['function'];
            }
        }

        return null;
    }

    /**
     * Disable auditing for this model instance
     */
    public function withoutAuditing(\Closure $callback)
    {
        static::flushEventListeners();

        try {
            return $callback();
        } finally {
            static::bootAuditable();
        }
    }

    /**
     * Check if model should be audited
     */
    public function shouldAudit(): bool
    {
        return property_exists($this, 'auditEnabled') ? $this->auditEnabled : true;
    }
}
