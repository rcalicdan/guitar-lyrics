<?php

namespace App\Controllers\Homepage;

use App\Controllers\BaseController;
use App\Models\Feedback;
use App\Requests\Feedback\StoreFeedbackRequest;
use CodeIgniter\HTTP\ResponseInterface;

class FeedbackController extends BaseController
{
    public function index()
    {
        return blade_view('contents.homepage.feedback');
    }

    public function store()
    {
        Feedback::create(StoreFeedbackRequest::validateRequest());

        return redirect()->back()->with('success', 'Feedback submitted successfully');
    }
}