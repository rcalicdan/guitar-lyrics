<?php

namespace App\Controllers\Homepage;

use App\Controllers\BaseController;
use App\Helpers\AuditHelper;
use App\Models\Feedback;
use App\Requests\Feedback\StoreFeedbackRequest;

class FeedbackController extends BaseController
{
    public function index()
    {
        return blade_view('contents.homepage.feedback');
    }

    public function store()
    {
        $feedback = Feedback::create(StoreFeedbackRequest::validateRequest());
        AuditHelper::logCreated($feedback);

        return redirect()->back()->with('success', 'Feedback submitted successfully');
    }
}
