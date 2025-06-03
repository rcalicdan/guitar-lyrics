<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Feedback;
use App\Services\FeedbackService;
use CodeIgniter\HTTP\ResponseInterface;

class FeedbackController extends BaseController
{
    protected $feedbackService;

    public function __construct()
    {
        $this->feedbackService = new FeedbackService();
    }

    public function index()
    {
        $this->authorizeOrNotFound('viewAny', Feedback::class);

        $filters = $this->feedbackService->getSearchFilters();
        $feedbacks = $this->feedbackService->getPaginatedFeedbacks($filters, 20);
        $stats = $this->feedbackService->getFeedbackStats($filters);
        $sortOptions = $this->feedbackService->getSortOptions();

        return blade_view('contents.feedback.index', [
            'feedbacks' => $feedbacks,
            'filters' => $filters,
            'stats' => $stats,
            'sortOptions' => $sortOptions,
            'hasActiveFilters' => $this->feedbackService->hasActiveFilters($filters)
        ]);
    }

    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);

        $this->authorizeOrNotFound('view', $feedback);

        return blade_view('contents.feedback.index', [
            'feedback' => $feedback,
            'isShowing' => true,
        ]);
    }

    public function delete($id)
    {
        $feedback = Feedback::findOrFail($id);
        $this->authorize('delete', $feedback);
        $feedback->delete();

        return redirect()->back()->with('error', 'Failed to delete feedback.');
    }


    public function export()
    {
        $this->authorizeOrNotFound('export', Feedback::class);

        $filters = $this->feedbackService->getSearchFilters();
        $feedbacks = $this->feedbackService->exportFeedbacks($filters);

        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="feedbacks_' . date('Y-m-d') . '.csv"')
            ->setBody($this->generateCsv($feedbacks));
    }

    public function clearSearch()
    {
        return redirect()->to(base_url('feedbacks'));
    }

    private function generateCsv($feedbacks)
    {
        $output = "ID,Name,Email,Content,Created At\n";

        foreach ($feedbacks as $feedback) {
            $output .= sprintf(
                "%d,\"%s\",\"%s\",\"%s\",\"%s\"\n",
                $feedback->id,
                str_replace('"', '""', $feedback->name ?: 'Anonymous'),
                str_replace('"', '""', $feedback->email ?: 'Not provided'),
                str_replace('"', '""', $feedback->content),
                $feedback->created_at->format('Y-m-d H:i:s')
            );
        }

        return $output;
    }
}
