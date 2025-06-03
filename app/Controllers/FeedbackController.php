<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Feedback;
use CodeIgniter\HTTP\ResponseInterface;

class FeedbackController extends BaseController
{
    public function index()
    {
        $feedbacks = Feedback::paginateWithQueryString(20);

        return blade_view('contents.feedback.index', ['feedbacks' => $feedbacks]);
    }

    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);

        return blade_view('contents.feedback.index', ['feedback' => $feedback, 'isShowing' => true]);
    }

    public function delete($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->back()->with('success', 'Feedback deleted successfully.');
    }
}
