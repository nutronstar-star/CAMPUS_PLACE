<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Interview;
use App\Models\Offer;
use App\Models\Notification;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function create(Application $application)
    {
        if ($application->job->company_id !== auth()->user()->companyProfile->id) { abort(403); }
        return view('company.interviews.create', compact('application'));
    }

    public function store(Request $request, Application $application)
    {
        $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'mode' => 'required|in:online,offline',
            'meeting_link' => 'nullable|url|required_if:mode,online',
            'venue' => 'nullable|string|required_if:mode,offline',
        ]);

        Interview::create([
            'application_id' => $application->id,
            'round_number' => 1,
            'round_name' => 'Technical Round',
            'mode' => $request->mode,
            'scheduled_at' => $request->scheduled_at,
            'duration_minutes' => 60,
            'meeting_link' => $request->meeting_link,
            'venue' => $request->venue,
            'result' => 'pending',
        ]);

        $application->update(['status' => 'interview']);

        // Notify student
        Notification::create([
            'user_id' => $application->student->user_id,
            'title' => 'Interview Scheduled',
            'message' => 'Interview scheduled for ' . $application->job->title . ' at ' . $application->job->company->name . ' on ' . $request->scheduled_at . ' (' . $request->mode . ').',
            'type' => 'interview',
            'is_critical' => true,
        ]);

        return redirect()->route('company.jobs.applicants', $application->job_id)
                         ->with('success', 'Interview scheduled successfully.');
    }

    public function releaseOffer(Request $request, Application $application)
    {
        if ($application->job->company_id !== auth()->user()->companyProfile->id) { abort(403); }

        // FIX: accept optional PDF offer letter
        $request->validate([
            'offer_letter' => 'nullable|mimes:pdf|max:5120',
        ]);

        $offerLetterUrl = null;
        if ($request->hasFile('offer_letter')) {
            $offerLetterUrl = $request->file('offer_letter')->store('offer-letters', 'public');
        }

        Offer::create([
            'student_id' => $application->student_id,
            'company_id' => $application->job->company_id,
            'job_id' => $application->job_id,
            'college_id' => $application->college_id,
            'package' => $application->job->package_max,
            'offer_letter_url' => $offerLetterUrl,
            'status' => 'released',
            'acceptance_deadline' => now()->addDays(7),
        ]);

        $application->update(['status' => 'selected']);
        $application->student->update(['status' => 'placed']);

        // Notify student
        Notification::create([
            'user_id' => $application->student->user_id,
            'title' => 'Offer Released',
            'message' => 'You received an offer for ' . $application->job->title . ' at ' . $application->job->company->name . '. Respond by ' . now()->addDays(7)->format('d M Y') . '.',
            'type' => 'offer',
            'is_critical' => true,
        ]);

        return back()->with('success', 'Offer released successfully!');
    }
}
