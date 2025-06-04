<?php

namespace App\Helpers;

use App\Models\AuditLog;

class AuditHelper
{
    public static function log($model, string $event, array $oldValues = [], array $newValues = [])
    {
        AuditLog::create([
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
            'event' => $event,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'user_id' => session()->get('auth_user_id'),
            'ip_address' => service('request')->getIPAddress(),
            'user_agent' => service('request')->getUserAgent()->getAgentString(),
        ]);
    }

    public static function logCreated($model)
    {
        self::log($model, 'created', [], $model->getAttributes());
    }

    public static function logUpdated($model, array $originalData)
    {
        $newValues = $model->getAttributes();
        $changedValues = [];

        foreach ($newValues as $key => $value) {
            if (isset($originalData[$key]) && $originalData[$key] !== $value) {
                $changedValues[$key] = $value;
            }
        }

        self::log($model, 'updated', $originalData, $changedValues);
    }

    public static function logDeleted($model)
    {
        self::log($model, 'deleted', $model->getAttributes(), []);
    }
}
