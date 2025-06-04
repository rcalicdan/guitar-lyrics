<?php

namespace App\Libraries\AuditLogs;

use App\Services\AuditService;

trait AuditablePivot
{
    /**
     * Boot the auditable pivot trait
     */
    protected static function bootAuditablePivot(): void
    {
        static::created(function ($pivot) {
            $pivot->auditPivotCreated();
        });

        static::updated(function ($pivot) {
            $pivot->auditPivotUpdated();
        });

        static::deleted(function ($pivot) {
            $pivot->auditPivotDeleted();
        });
    }

    /**
     * Handle pivot created event
     */
    protected function auditPivotCreated(): void
    {
        if ($this->shouldAuditPivot('created')) {
            // For Comments model, get the parent model (Song or User)
            $parentModel = $this->getAuditableParent();
            
            if ($parentModel) {
                AuditService::log(
                    $parentModel,
                    'pivot_created',
                    [],
                    [
                        'pivot_table' => $this->getTable(),
                        'pivot_data' => AuditService::getFilteredAttributes($this),
                        'related_models' => $this->getRelatedModelsInfo()
                    ],
                    $this->getPivotAuditMetadata('created')
                );
            }
        }
    }

    /**
     * Handle pivot updated event
     */
    protected function auditPivotUpdated(): void
    {
        if ($this->shouldAuditPivot('updated')) {
            $changes = $this->getChanges();
            
            if (!empty($changes)) {
                $parentModel = $this->getAuditableParent();
                
                if ($parentModel) {
                    $oldValues = [];
                    $newValues = [];
                    
                    foreach ($changes as $key => $newValue) {
                        $oldValues[$key] = $this->getOriginal($key);
                        $newValues[$key] = $newValue;
                    }
                    
                    AuditService::log(
                        $parentModel,
                        'pivot_updated',
                        [
                            'pivot_table' => $this->getTable(),
                            'pivot_data' => $oldValues,
                            'related_models' => $this->getRelatedModelsInfo()
                        ],
                        [
                            'pivot_table' => $this->getTable(),
                            'pivot_data' => $newValues,
                            'related_models' => $this->getRelatedModelsInfo()
                        ],
                        $this->getPivotAuditMetadata('updated')
                    );
                }
            }
        }
    }

    /**
     * Handle pivot deleted event
     */
    protected function auditPivotDeleted(): void
    {
        if ($this->shouldAuditPivot('deleted')) {
            $parentModel = $this->getAuditableParent();
            
            if ($parentModel) {
                AuditService::log(
                    $parentModel,
                    'pivot_deleted',
                    [
                        'pivot_table' => $this->getTable(),
                        'pivot_data' => AuditService::getFilteredAttributes($this),
                        'related_models' => $this->getRelatedModelsInfo()
                    ],
                    [],
                    $this->getPivotAuditMetadata('deleted')
                );
            }
        }
    }

    /**
     * Get the main model to associate audit logs with
     * Override this method in your pivot model
     */
    protected function getAuditableParent()
    {
        // For Comments, we'll use the Song as the main auditable parent
        if (method_exists($this, 'song')) {
            return $this->song;
        }
        
        // Fallback to user if no song
        if (method_exists($this, 'user')) {
            return $this->user;
        }
        
        return null;
    }

    /**
     * Get information about related models
     */
    protected function getRelatedModelsInfo(): array
    {
        $info = [];
        
        // For Comments model
        if (method_exists($this, 'user') && $this->user) {
            $info['user'] = [
                'id' => $this->user->id,
                'name' => $this->user->full_name,
                'email' => $this->user->email
            ];
        }
        
        if (method_exists($this, 'song') && $this->song) {
            $info['song'] = [
                'id' => $this->song->id,
                'title' => $this->song->title,
                'slug' => $this->song->slug
            ];
        }
        
        if (method_exists($this, 'parent') && $this->parent) {
            $info['parent_comment'] = [
                'id' => $this->parent->id,
                'content' => substr($this->parent->content, 0, 50) . '...'
            ];
        }
        
        return $info;
    }

    /**
     * Check if pivot should be audited
     */
    protected function shouldAuditPivot(string $event): bool
    {
        if (property_exists($this, 'auditPivotEvents')) {
            return in_array($event, $this->auditPivotEvents);
        }
        
        if (property_exists($this, 'auditPivotExclude')) {
            return !in_array($event, $this->auditPivotExclude);
        }
        
        return true;
    }

    /**
     * Get pivot audit metadata
     */
    protected function getPivotAuditMetadata(string $event): array
    {
        return [
            'pivot_event' => $event,
            'pivot_table' => $this->getTable()
        ];
    }
}