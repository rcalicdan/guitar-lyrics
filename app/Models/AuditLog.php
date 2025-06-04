<?php

namespace App\Models;

use Rcalicdan\Ci4Larabridge\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'event',
        'old_values',
        'new_values',
        'changes',
        'user_id',
        'user_type',
        'ip_address',
        'user_agent',
        'metadata'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'changes' => 'array',
        'metadata' => 'array',
    ];

    /**
     * Get the auditable model
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who made the change
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo($this->user_type ?? User::class, 'user_id');
    }

    /**
     * Scope to filter by model type
     */
    public function scopeForModel($query, string $modelType)
    {
        return $query->where('auditable_type', $modelType);
    }

    /**
     * Scope to filter by event type
     */
    public function scopeForEvent($query, string $event)
    {
        return $query->where('event', $event);
    }

    /**
     * Get formatted changes for display
     */
    public function getFormattedChangesAttribute(): array
    {
        $formatted = [];
        
        if ($this->changes) {
            foreach ($this->changes as $field => $change) {
                $formatted[$field] = [
                    'from' => $change['old'] ?? null,
                    'to' => $change['new'] ?? null,
                ];
            }
        }
        
        return $formatted;
    }
}