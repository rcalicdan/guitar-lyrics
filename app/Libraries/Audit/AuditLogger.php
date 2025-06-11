<?php

namespace App\Libraries\Audit;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditLogger
{
    protected static array $excludedAttributes = [
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token',
        'password',
        'password_confirmation',
    ];

    public static function created(Model $model): void
    {
        static::log($model, 'created', [], $model->getAttributes());
    }

    public static function updated(Model $model): void
    {
        $originalData = $model->getOriginal();
        $newData = $model->getAttributes();
        
        $changes = static::getChanges($originalData, $newData);
        
        if (!empty($changes['old']) || !empty($changes['new'])) {
            static::log($model, 'updated', $changes['old'], $changes['new']);
        }
    }

    public static function deleted(Model $model): void
    {
        static::log($model, 'deleted', $model->getOriginal(), []);
    }

    public static function attached(Model $model, string $relation, $attachedIds, array $attributes = []): void
    {
        $attachedIds = is_array($attachedIds) ? $attachedIds : [$attachedIds];
        
        static::log($model, 'attached', [], [
            'relation' => $relation,
            'attached_ids' => $attachedIds,
            'pivot_attributes' => $attributes,
        ]);
    }

    public static function detached(Model $model, string $relation, $detachedIds): void
    {
        $detachedIds = is_array($detachedIds) ? $detachedIds : [$detachedIds];
        
        static::log($model, 'detached', [
            'relation' => $relation,
            'detached_ids' => $detachedIds,
        ], []);
    }

    public static function synced(Model $model, string $relation, array $changes): void
    {
        if (!empty($changes['attached']) || !empty($changes['detached']) || !empty($changes['updated'])) {
            static::log($model, 'synced', [], [
                'relation' => $relation,
                'changes' => $changes,
            ]);
        }
    }

    protected static function log(Model $model, string $event, array $oldValues, array $newValues): void
    {
        // Filter out excluded attributes
        $oldValues = static::filterAttributes($oldValues);
        $newValues = static::filterAttributes($newValues);

        AuditLog::create([
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
            'event' => $event,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'user_id' => static::getCurrentUserId(),
            'ip_address' => static::getClientIpAddress(),
            'user_agent' => static::getUserAgent(),
        ]);
    }

    protected static function getChanges(array $original, array $current): array
    {
        $oldValues = [];
        $newValues = [];

        foreach ($current as $key => $value) {
            if (array_key_exists($key, $original) && $original[$key] !== $value) {
                $oldValues[$key] = $original[$key];
                $newValues[$key] = $value;
            }
        }

        return ['old' => $oldValues, 'new' => $newValues];
    }

    protected static function filterAttributes(array $attributes): array
    {
        return array_diff_key($attributes, array_flip(static::$excludedAttributes));
    }

    protected static function getCurrentUserId(): ?int
    {
        return session()->get('auth_user_id');
    }

    protected static function getClientIpAddress(): ?string
    {
        return service('request')->getIPAddress();
    }

    protected static function getUserAgent(): ?string
    {
        return service('request')->getUserAgent()->getAgentString();
    }

    public static function setExcludedAttributes(array $attributes): void
    {
        static::$excludedAttributes = $attributes;
    }

    public static function addExcludedAttributes(array $attributes): void
    {
        static::$excludedAttributes = array_merge(static::$excludedAttributes, $attributes);
    }
}