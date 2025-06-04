<?php

namespace App\Libraries\AuditLogs;

use App\Models\AuditLog;
use App\Libraries\AuditLogs\AuditService;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait Auditable
{
    /**
     * Store original pivot data for comparison
     */
    protected $originalPivotData = [];

    /**
     * Boot the auditable trait
     */
    protected static function bootAuditable(): void
    {
        // Add debugging
        error_log('Auditable trait booted for: ' . static::class);
        
        // Listen for model events
        static::created(function ($model) {
            error_log('Model created event triggered for: ' . get_class($model));
            $model->auditCreated();
        });

        static::updated(function ($model) {
            error_log('Model updated event triggered for: ' . get_class($model));
            $model->auditUpdated();
        });

        static::deleted(function ($model) {
            error_log('Model deleted event triggered for: ' . get_class($model));
            $model->auditDeleted();
        });

        if (method_exists(static::class, 'pivotAttached')) {
            static::pivotAttached(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
                $model->auditPivotAttached($relationName, $pivotIds, $pivotIdsAttributes);
            });
        }

        if (method_exists(static::class, 'pivotDetached')) {
            static::pivotDetached(function ($model, $relationName, $pivotIds) {
                $model->auditPivotDetached($relationName, $pivotIds);
            });
        }

        if (method_exists(static::class, 'pivotUpdated')) {
            static::pivotUpdated(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
                $model->auditPivotUpdated($relationName, $pivotIds, $pivotIdsAttributes);
            });
        }
    }

    /**
     * Get all audit logs for this model
     */
    public function auditLogs(): MorphMany
    {
        return $this->morphMany(AuditLog::class, 'auditable')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get recent audit logs
     */
    public function recentAuditLogs(int $limit = 10): MorphMany
    {
        return $this->auditLogs()->limit($limit);
    }

   /**
     * Handle created event
     */
    protected function auditCreated(): void
    {
        error_log('auditCreated called for: ' . get_class($this));
        
        if ($this->shouldAudit('created')) {
            error_log('Should audit created - proceeding with audit log');
            $newValues = AuditService::getFilteredAttributes($this);

            try {
                $auditLog = AuditService::log(
                    $this,
                    'created',
                    [],
                    $newValues,
                    $this->getAuditMetadata('created')
                );
                error_log('Audit log created with ID: ' . $auditLog->id);
            } catch (\Exception $e) {
                error_log('Error creating audit log: ' . $e->getMessage());
            }
        } else {
            error_log('Should not audit created event');
        }
    }

    /**
     * Handle updated event
     */
    protected function auditUpdated(): void
    {
        if ($this->shouldAudit('updated')) {
            $changes = $this->getChanges();

            if (!empty($changes)) {
                $oldValues = [];
                $newValues = [];

                foreach ($changes as $key => $newValue) {
                    $oldValues[$key] = $this->getOriginal($key);
                    $newValues[$key] = $newValue;
                }

                $oldValues = AuditService::getFilteredAttributes($this, $oldValues);
                $newValues = AuditService::getFilteredAttributes($this, $newValues);

                AuditService::log(
                    $this,
                    'updated',
                    $oldValues,
                    $newValues,
                    $this->getAuditMetadata('updated')
                );
            }
        }
    }

    /**
     * Handle deleted event
     */
    protected function auditDeleted(): void
    {
        if ($this->shouldAudit('deleted')) {
            $oldValues = AuditService::getFilteredAttributes($this);

            AuditService::log(
                $this,
                'deleted',
                $oldValues,
                [],
                $this->getAuditMetadata('deleted')
            );
        }
    }

    /**
     * Handle pivot attached event
     */
    protected function auditPivotAttached(string $relationName, array $pivotIds, array $pivotIdsAttributes): void
    {
        if ($this->shouldAudit('pivot_attached')) {
            $relation = $this->$relationName();
            $relatedModel = $relation->getRelated();

            foreach ($pivotIds as $pivotId) {
                $pivotAttributes = $pivotIdsAttributes[$pivotId] ?? [];
                $relatedRecord = $relatedModel->find($pivotId);

                AuditService::log(
                    $this,
                    'pivot_attached',
                    [],
                    [
                        'relation' => $relationName,
                        'related_id' => $pivotId,
                        'related_type' => get_class($relatedModel),
                        'related_name' => $this->getRelatedModelName($relatedRecord),
                        'pivot_attributes' => $pivotAttributes
                    ],
                    array_merge(
                        $this->getAuditMetadata('pivot_attached'),
                        ['relation_name' => $relationName]
                    )
                );
            }
        }
    }

    /**
     * Handle pivot detached event
     */
    protected function auditPivotDetached(string $relationName, array $pivotIds): void
    {
        if ($this->shouldAudit('pivot_detached')) {
            $relation = $this->$relationName();
            $relatedModel = $relation->getRelated();

            foreach ($pivotIds as $pivotId) {
                $relatedRecord = $relatedModel->find($pivotId);

                AuditService::log(
                    $this,
                    'pivot_detached',
                    [
                        'relation' => $relationName,
                        'related_id' => $pivotId,
                        'related_type' => get_class($relatedModel),
                        'related_name' => $this->getRelatedModelName($relatedRecord)
                    ],
                    [],
                    array_merge(
                        $this->getAuditMetadata('pivot_detached'),
                        ['relation_name' => $relationName]
                    )
                );
            }
        }
    }

    /**
     * Handle pivot updated event
     */
    protected function auditPivotUpdated(string $relationName, array $pivotIds, array $pivotIdsAttributes): void
    {
        if ($this->shouldAudit('pivot_updated')) {
            $relation = $this->$relationName();
            $relatedModel = $relation->getRelated();

            foreach ($pivotIds as $pivotId) {
                $pivotAttributes = $pivotIdsAttributes[$pivotId] ?? [];
                $relatedRecord = $relatedModel->find($pivotId);

                AuditService::log(
                    $this,
                    'pivot_updated',
                    [], // Would need to track original pivot values
                    [
                        'relation' => $relationName,
                        'related_id' => $pivotId,
                        'related_type' => get_class($relatedModel),
                        'related_name' => $this->getRelatedModelName($relatedRecord),
                        'pivot_attributes' => $pivotAttributes
                    ],
                    array_merge(
                        $this->getAuditMetadata('pivot_updated'),
                        ['relation_name' => $relationName]
                    )
                );
            }
        }
    }

    /**
     * Get a readable name for the related model
     */
    protected function getRelatedModelName($relatedRecord): ?string
    {
        if (!$relatedRecord) {
            return null;
        }

        // Try common name attributes
        $nameAttributes = ['name', 'title', 'full_name', 'email', 'username'];

        foreach ($nameAttributes as $attribute) {
            if (isset($relatedRecord->$attribute)) {
                return $relatedRecord->$attribute;
            }
        }

        return $relatedRecord->getKey();
    }

    /**
     * Override attach method to include auditing
     */
    public function auditableAttach($relation, $id, array $attributes = [], $touch = true)
    {
        $relationInstance = $this->$relation();

        if ($relationInstance instanceof BelongsToMany) {
            // Store before state for comparison
            $beforeIds = $relationInstance->pluck($relationInstance->getRelatedKeyName())->toArray();

            // Perform the attach
            $result = $relationInstance->attach($id, $attributes, $touch);

            // Get the attached IDs
            $attachedIds = is_array($id) ? array_keys($id) : [$id];
            $pivotAttributes = is_array($id) ? $id : [$id => $attributes];

            // Audit the attachment
            $this->auditPivotAttached($relation, $attachedIds, $pivotAttributes);

            return $result;
        }

        return $this->$relation()->attach($id, $attributes, $touch);
    }

    /**
     * Override detach method to include auditing
     */
    public function auditableDetach($relation, $ids = null, $touch = true)
    {
        $relationInstance = $this->$relation();

        if ($relationInstance instanceof BelongsToMany) {
            // Get current related IDs before detaching
            $beforeIds = $relationInstance->pluck($relationInstance->getRelatedKeyName())->toArray();

            // Perform the detach
            $result = $relationInstance->detach($ids, $touch);

            // Determine which IDs were actually detached
            $detachedIds = $ids ? (is_array($ids) ? $ids : [$ids]) : $beforeIds;

            // Audit the detachment
            $this->auditPivotDetached($relation, $detachedIds);

            return $result;
        }

        return $this->$relation()->detach($ids, $touch);
    }

    /**
     * Override sync method to include auditing
     */
    public function auditableSync($relation, $ids, $detaching = true)
    {
        $relationInstance = $this->$relation();

        if ($relationInstance instanceof BelongsToMany) {
            // Get current state
            $beforeIds = $relationInstance->pluck($relationInstance->getRelatedKeyName())->toArray();

            // Perform the sync
            $result = $relationInstance->sync($ids, $detaching);

            // Audit attached
            if (!empty($result['attached'])) {
                $attachedAttributes = [];
                foreach ($result['attached'] as $attachedId) {
                    $attachedAttributes[$attachedId] = is_array($ids) ? ($ids[$attachedId] ?? []) : [];
                }
                $this->auditPivotAttached($relation, $result['attached'], $attachedAttributes);
            }

            // Audit detached
            if (!empty($result['detached'])) {
                $this->auditPivotDetached($relation, $result['detached']);
            }

            // Audit updated
            if (!empty($result['updated'])) {
                $updatedAttributes = [];
                foreach ($result['updated'] as $updatedId) {
                    $updatedAttributes[$updatedId] = is_array($ids) ? ($ids[$updatedId] ?? []) : [];
                }
                $this->auditPivotUpdated($relation, $result['updated'], $updatedAttributes);
            }

            return $result;
        }

        return $this->$relation()->sync($ids, $detaching);
    }

    /**
     * Determine if this event should be audited
     */
    protected function shouldAudit(string $event): bool
    {
        if (property_exists($this, 'auditEvents')) {
            return in_array($event, $this->auditEvents);
        }

        if (property_exists($this, 'auditExclude')) {
            return !in_array($event, $this->auditExclude);
        }

        return true;
    }

    /**
     * Get additional metadata for the audit log
     */
    protected function getAuditMetadata(string $event): array
    {
        return [];
    }
}
