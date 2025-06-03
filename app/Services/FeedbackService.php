<?php

namespace App\Services;

use App\Models\Feedback;
use Illuminate\Support\Carbon;

class FeedbackService
{
    /**
     * Get paginated feedbacks with optional search filters
     */
    public function getPaginatedFeedbacks(array $filters = [], int $perPage = 20)
    {
        return Feedback::query()
            ->when($filters['name'] ?? null, function ($query, $name) {
                return $query->where('name', 'LIKE', "%{$name}%");
            })
            ->when($filters['email'] ?? null, function ($query, $email) {
                return $query->where('email', 'LIKE', "%{$email}%");
            })
            ->when($filters['content'] ?? null, function ($query, $content) {
                return $query->where('content', 'LIKE', "%{$content}%");
            })
            ->when($filters['date_from'] ?? null, function ($query, $dateFrom) {
                return $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($filters['date_to'] ?? null, function ($query, $dateTo) {
                return $query->whereDate('created_at', '<=', $dateTo);
            })
            ->when($this->hasDateRange($filters), function ($query) use ($filters) {
                // Additional logic if both dates are provided
                return $query->whereBetween('created_at', [
                    $filters['date_from'] . ' 00:00:00',
                    $filters['date_to'] . ' 23:59:59'
                ]);
            })
            ->when($filters['status'] ?? null, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Find feedback by ID with optional relationships
     */
    public function findFeedback(int $id, array $with = [])
    {
        return Feedback::query()
            ->when($with, function ($query, $relationships) {
                return $query->with($relationships);
            })
            ->find($id);
    }

    /**
     * Get feedback with search and additional filters
     */
    public function searchFeedbacks(array $filters = [])
    {
        return Feedback::query()
            ->when($filters['search'] ?? null, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('content', 'LIKE', "%{$search}%");
                });
            })
            ->when($filters['name'] ?? null, function ($query, $name) {
                return $query->where('name', 'LIKE', "%{$name}%");
            })
            ->when($filters['email'] ?? null, function ($query, $email) {
                return $query->where('email', 'LIKE', "%{$email}%");
            })
            ->when($filters['content'] ?? null, function ($query, $content) {
                return $query->where('content', 'LIKE', "%{$content}%");
            })
            ->when($filters['has_email'] ?? null, function ($query, $hasEmail) {
                return $hasEmail
                    ? $query->whereNotNull('email')->where('email', '!=', '')
                    : $query->whereNull('email')->orWhere('email', '');
            })
            ->when($filters['is_anonymous'] ?? null, function ($query, $isAnonymous) {
                return $isAnonymous
                    ? $query->whereNull('name')->orWhere('name', '')
                    : $query->whereNotNull('name')->where('name', '!=', '');
            })
            ->when($filters['date_from'] ?? null, function ($query, $dateFrom) {
                return $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($filters['date_to'] ?? null, function ($query, $dateTo) {
                return $query->whereDate('created_at', '<=', $dateTo);
            })
            ->when($filters['sort_by'] ?? null, function ($query, $sortBy) use ($filters) {
                $direction = $filters['sort_direction'] ?? 'desc';
                return $query->orderBy($sortBy, $direction);
            }, function ($query) {
                return $query->latest('created_at');
            })
            ->get();
    }

    /**
     * Get feedback statistics
     */
    public function getFeedbackStats(array $filters = [])
    {
        $baseQuery = Feedback::query()
            ->when($filters['date_from'] ?? null, function ($query, $dateFrom) {
                return $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($filters['date_to'] ?? null, function ($query, $dateTo) {
                return $query->whereDate('created_at', '<=', $dateTo);
            });

        return [
            'total' => (clone $baseQuery)->count(),
            'anonymous' => (clone $baseQuery)->where(function ($q) {
                $q->whereNull('name')->orWhere('name', '');
            })->count(),
            'with_email' => (clone $baseQuery)->whereNotNull('email')->where('email', '!=', '')->count(),
            'recent' => (clone $baseQuery)->where('created_at', '>=', Carbon::now()->subDays(7))->count(),
        ];
    }

    /**
     * Get search filters from request
     */
    public function getSearchFilters(): array
    {
        $request = service('request');

        return array_filter([
            'search' => $request->getGet('search'),
            'name' => $request->getGet('name'),
            'email' => $request->getGet('email'),
            'content' => $request->getGet('content'),
            'date_from' => $request->getGet('date_from'),
            'date_to' => $request->getGet('date_to'),
            'has_email' => $request->getGet('has_email'),
            'is_anonymous' => $request->getGet('is_anonymous'),
            'status' => $request->getGet('status'),
            'sort_by' => $request->getGet('sort_by'),
            'sort_direction' => $request->getGet('sort_direction'),
        ], function ($value) {
            return $value !== null && $value !== '';
        });
    }

    /**
     * Check if any search filters are applied
     */
    public function hasActiveFilters(array $filters): bool
    {
        return !empty($filters);
    }

    /**
     * Check if date range filters are provided
     */
    protected function hasDateRange(array $filters): bool
    {
        return !empty($filters['date_from']) && !empty($filters['date_to']);
    }

    /**
     * Get available sort options
     */
    public function getSortOptions(): array
    {
        return [
            'created_at' => 'Date Created',
            'name' => 'Name',
            'email' => 'Email',
            'updated_at' => 'Last Updated',
        ];
    }

    /**
     * Export feedbacks based on filters
     */
    public function exportFeedbacks(array $filters = [], string $format = 'csv')
    {
        $feedbacks = Feedback::query()
            ->when($filters['name'] ?? null, function ($query, $name) {
                return $query->where('name', 'LIKE', "%{$name}%");
            })
            ->when($filters['email'] ?? null, function ($query, $email) {
                return $query->where('email', 'LIKE', "%{$email}%");
            })
            ->when($filters['content'] ?? null, function ($query, $content) {
                return $query->where('content', 'LIKE', "%{$content}%");
            })
            ->when($filters['date_from'] ?? null, function ($query, $dateFrom) {
                return $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($filters['date_to'] ?? null, function ($query, $dateTo) {
                return $query->whereDate('created_at', '<=', $dateTo);
            })
            ->select(['id', 'name', 'email', 'content', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->get();

        return $feedbacks;
    }
}
