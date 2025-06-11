<?php

namespace App\Models;

use App\Traits\Auditable;
use Rcalicdan\Ci4Larabridge\Models\Model;

abstract class BaseModel extends Model
{
    use Auditable;

    /**
     * Attributes that should not be audited
     */
    protected array $auditExclude = [];

    /**
     * Enable/disable auditing for this model
     */
    protected bool $auditEnabled = true;

    /**
     * Get attributes that should be excluded from auditing
     */
    public function getAuditExclude(): array
    {
        return array_merge([
            'created_at',
            'updated_at',
            'deleted_at',
        ], $this->auditExclude);
    }
}