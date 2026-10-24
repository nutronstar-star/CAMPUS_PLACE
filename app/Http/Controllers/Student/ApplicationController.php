<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Offer;
use App\Models\PlacementRecord;
use App\Models\College;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $student = auth()->user()->studentProfile;

        $applications = $student->applications()
            ->with(['job.company', 'interviews'])
            ->latest()
            ->paginate(10);

        $offers = Offer::where('student_id', $student->id)
            ->where('status', 'released')
            ->with(['company', 'job'])
            ->get();

        return view('student.applications.index', compact('applications', 'offers'));
    }

    public function respondToOffer(Request $request, Offer $offer)
    {
        if ($offer->student_id !== auth()->user()->studentProfile->id) { abort(403); }
        if ($offer->status !== 'released') { return back()->with('error', 'This offer is no longer active.'); }

        $request->validate(['action' => 'required|in:accept,reject']);

        if ($request->action === 'accept') {
            $offer->update(['status' => 'accepted', 'responded_at' => now()]);

            Application::where('student_id', $offer->student_id)
                       ->where('job_id', $offer->job_id)
                       ->update(['status' => 'selected']);

            // FIX: create placement record (matches rules IO10, PP5)
            $college = College::find($offer->college_id);
            $priorPlacements = PlacementRecord::where('student_id', $offer->student_id)->count();

            PlacementRecord::create([
                'student_id' => $offer->student_id,
                'company_id' => $offer->company_id,
                'job_id' => $offer->job_id,
                'college_id' => $offer->college_id,
                'state_id' => $college ? $college->state_id : 1,
                'package' => $offer->package,
                'job_type' => $offer->job->job_type ?? 'full_time',
                'placement_year' => (int) now()->format('Y'),
                'is_multiple_offer' => $priorPlacements > 0,
            ]);

            // Notify company
            \App\Models\Notification::create([
                'user_id' => $offer->company->user_id,
                'title' => 'Offer Accepted',
                'message' => $offer->student->user->name . ' has accepted the offer for ' . $offer->job->title . '.',
                'type' => 'announcement',
                'is_critical' => true,
            ]);

            return back()->with('success', 'Congratulations! You have accepted the offer.');
        } else {
            $offer->update(['status' => 'rejected', 'responded_at' => now()]);
            return back()->with('success', 'You have declined the offer.');
        }
    }

    public function withdraw(Application $application)
    {
        $student = auth()->user()->studentProfile;

        if ($application->student_id !== $student->id) { abort(403); }

        if (\Carbon\Carbon::parse($application->job->deadline)->isPast()) {
            return back()->with('error', 'Cannot withdraw. The application deadline has passed.');
        }

        if (in_array($application->status, ['selected', 'rejected', 'withdrawn'])) {
            return back()->with('error', 'You cannot withdraw this application at its current status.');
        }

        $application->update(['status' => 'withdrawn']);

        \App\Models\Notification::create([
            'user_id' => $application->job->company->user_id,
            'title' => 'Application Withdrawn',
            'message' => $student->user->name . ' has withdrawn their application for ' . $application->job->title . '.',
            'type' => 'announcement',
            'is_critical' => false,
        ]);

        return back()->with('success', 'Application withdrawn successfully.');
    }
}
