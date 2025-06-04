<?php

namespace App\Traits;

use CodeIgniter\Events\Events;

trait PivotAuditable
{
    /**
     * Log pivot attach operation
     */
    protected function logPivotAttach(string $relation, $relatedModel, array $pivotData = [])
    {
        Events::trigger('pivot_attached', [
            'parent_model' => $this,
            'relation' => $relation,
            'related_model' => get_class($relatedModel),
            'related_id' => is_object($relatedModel) ? $relatedModel->getKey() : $relatedModel,
            'pivot_data' => $pivotData,
        ]);
    }

    /**
     * Log pivot detach operation
     */
    protected function logPivotDetach(string $relation, $relatedModel, array $pivotData = [])
    {
        Events::trigger('pivot_detached', [
            'parent_model' => $this,
            'relation' => $relation,
            'related_model' => get_class($relatedModel),
            'related_id' => is_object($relatedModel) ? $relatedModel->getKey() : $relatedModel,
            'pivot_data' => $pivotData,
        ]);
    }

    /**
     * Log pivot update operation
     */
    protected function logPivotUpdate(string $relation, $relatedModel, array $oldData, array $newData)
    {
        Events::trigger('pivot_updated', [
            'parent_model' => $this,
            'relation' => $relation,
            'related_model' => get_class($relatedModel),
            'related_id' => is_object($relatedModel) ? $relatedModel->getKey() : $relatedModel,
            'old_data' => $oldData,
            'new_data' => $newData,
        ]);
    }
}