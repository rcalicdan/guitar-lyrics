<?php
// app/Services/AuditService.php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditService
{
    /**
     * Log an audit event
     */
    public static function log(
        Model $model,
        string $event,
        array $oldValues = [],
        array $newValues = [],
        array $metadata = []
    ): AuditLog {
        $changes = static::calculateChanges($oldValues, $newValues);
        
        return AuditLog::create([
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
            'event' => $event,
            'old_values' => $oldValues ?: null,
            'new_values' => $newValues ?: null,
            'changes' => $changes ?: null,
            'user_id' => Auth::id(),
            'user_type' => Auth::user() ? get_class(Auth::user()) : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'metadata' => $metadata ?: null,
        ]);
    }

    /**
     * Log pivot relationship changes
     */
    public static function logPivot(
        Model $model,
        string $event,
        string $relationName,
        mixed $relatedId,
        array $pivotData = [],
        array $metadata = []
    ): AuditLog {
        $eventData = [
            'relation_name' => $relationName,
            'related_id' => $relatedId,
            'pivot_data' => $pivotData
        ];

        return static::log(
            $model,
            $event,
            $event === 'pivot_detached' ? $eventData : [],
            $event !== 'pivot_detached' ? $eventData : [],
            array_merge($metadata, ['pivot_operation' => true])
        );
    }

    /**
     * Calculate what actually changed between old and new values
     */
    private static function calculateChanges(array $oldValues, array $newValues): array
    {
        $changes = [];
        
        // For pivot operations, handle specially
        if (isset($newValues['relation']) || isset($oldValues['relation'])) {
            return static::calculatePivotChanges($oldValues, $newValues);
        }
        
        // Check for new or changed values
        foreach ($newValues as $key => $newValue) {
            $oldValue = $oldValues[$key] ?? null;
            
            if ($oldValue !== $newValue) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $newValue
                ];
            }
        }
        
        // Check for removed values
        foreach ($oldValues as $key => $oldValue) {
            if (!array_key_exists($key, $newValues) && $oldValue !== null) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => null
                ];
            }
        }
        
        return $changes;
    }

    /**
     * Calculate changes for pivot operations
     */
    private static function calculatePivotChanges(array $oldValues, array $newValues): array
    {
        $changes = [];
        
        if (!empty($newValues['relation'])) {
            $changes['relationship'] = [
                'old' => $oldValues['relation'] ?? null,
                'new' => $newValues['relation']
            ];
        }
        
        if (!empty($newValues['related_id'])) {
            $changes['related_record'] = [
                'old' => $oldValues['related_id'] ?? null,
                'new' => $newValues['related_id']
            ];
        }
        
        if (!empty($newValues['pivot_attributes'])) {
            $changes['pivot_attributes'] = [
                'old' => $oldValues['pivot_attributes'] ?? [],
                'new' => $newValues['pivot_attributes']
            ];
        }
        
        return $changes;
    }

    /**
     * Get filtered attributes
     */
    public static function getFilteredAttributes(Model $model, ?array $attributes = null): array
    {
        $attributes = $attributes ?? $model->getAttributes();
        
        $hidden = $model->getHidden();
        $defaultExcluded = [
            'password',
            'remember_token',
            'email_verification_token',
            'password_reset_token',
        ];
        
        $excluded = array_merge($hidden, $defaultExcluded);
        
        foreach ($excluded as $field) {
            unset($attributes[$field]);
        }
        
        return $attributes;
    }
}