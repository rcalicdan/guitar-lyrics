<?php

namespace App\Http\Controllers;

use App\Controllers\BaseController;
use App\Models\AuditLog;
use App\Models\User;

class AuditLogController extends BaseController
{
    public function index()
    {
        $auditLogs = AuditLog::with('user')
            ->when(get('search'), fn($q) => $this->applySearchFilter($q, get('search')))
            ->when(get('event'), fn($q) => $q->where('event', get('event')))
            ->when(get('auditable_type'), fn($q) => $q->where('auditable_type', get('auditable_type')))
            ->when(get('user_id'), fn($q) => $q->where('user_id', get('user_id')))
            ->when(get('date_from'), fn($q) => $q->whereDate('created_at', '>=', get('date_from')))
            ->when(get('date_to'), fn($q) => $q->whereDate('created_at', '<=', get('date_to')))
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends($this->request->getGet());

        return blade_view('audit-logs.index', [
            'auditLogs' => $auditLogs,
            'events' => AuditLog::distinct()->pluck('event'),
            'auditableTypes' => AuditLog::distinct()->pluck('auditable_type'),
            'users' => User::select('id', 'name')->get()
        ]);
    }

    public function show($id)
    {
        $auditLog = AuditLog::with('user')->findOrFail($id);

        return blade_view('audit-logs.show', compact('auditLog'));
    }

    private function applySearchFilter($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('auditable_type', 'like', "%{$search}%")
                ->orWhere('event', 'like', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                });
        });
    }
}
