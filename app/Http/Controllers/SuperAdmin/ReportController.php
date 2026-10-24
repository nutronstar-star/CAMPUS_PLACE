<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PlacementRecord;
use App\Models\College;
use App\Models\Student;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalPlaced = PlacementRecord::count();
        $highestPackage = PlacementRecord::max('package') ?? 0;
        $averagePackage = PlacementRecord::avg('package') ?? 0;

        $stateStats = College::withCount(['students'])
            ->with('state')
            ->get()
            ->groupBy('state.name')
            ->map(function ($colleges, $stateName) {
                $studentIds = $colleges->pluck('students')->flatten()->pluck('id');
                $placed = PlacementRecord::whereIn('student_id', $studentIds)->count();
                $avgPackage = PlacementRecord::whereIn('student_id', $studentIds)->avg('package') ?? 0;

                return [
                    'state' => $stateName,
                    'total_colleges' => $colleges->count(),
                    'total_students' => $studentIds->count(),
                    'placed_students' => $placed,
                    'placement_rate' => $studentIds->count() > 0 ? round(($placed / $studentIds->count()) * 100, 2) : 0,
                    'avg_package' => round($avgPackage, 2),
                ];
            });

        return view('super-admin.reports.index', compact('totalPlaced', 'highestPackage', 'averagePackage', 'stateStats'));
    }

    /**
     * CSV: state-wise summary.
     */
    public function exportNationalSummary()
    {
        $filename = 'campusplace-state-wise-report-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel

            fputcsv($out, [
                'State',
                'Colleges',
                'Total Students',
                'Placed Students',
                'Placement Rate (%)',
                'Avg Package (INR)',
                'Highest Package (INR)',
            ]);

            $stateStats = College::withCount(['students'])
                ->with('state')
                ->get()
                ->groupBy('state.name');

            foreach ($stateStats as $stateName => $colleges) {
                $studentIds = $colleges->pluck('students')->flatten()->pluck('id');
                $total = $studentIds->count();
                $placed = PlacementRecord::whereIn('student_id', $studentIds)->count();
                $avg = PlacementRecord::whereIn('student_id', $studentIds)->avg('package') ?? 0;
                $highest = PlacementRecord::whereIn('student_id', $studentIds)->max('package') ?? 0;
                $rate = $total > 0 ? round(($placed / $total) * 100, 2) : 0;

                fputcsv($out, [
                    $stateName,
                    $colleges->count(),
                    $total,
                    $placed,
                    $rate,
                    round($avg, 2),
                    round($highest, 2),
                ]);
            }

            fputcsv($out, []);

            $totalStudents = Student::count();
            $totalPlaced = PlacementRecord::count();
            $overallAvg = PlacementRecord::avg('package') ?? 0;
            $overallHighest = PlacementRecord::max('package') ?? 0;
            $overallRate = $totalStudents > 0 ? round(($totalPlaced / $totalStudents) * 100, 2) : 0;

            fputcsv($out, [
                'TOTAL / NATIONAL',
                College::count(),
                $totalStudents,
                $totalPlaced,
                $overallRate,
                round($overallAvg, 2),
                round($overallHighest, 2),
            ]);

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * CSV: one row per placement record.
     */
    public function exportPlacements()
    {
        $filename = 'campusplace-placement-records-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'Placement ID',
                'Student Name',
                'Enrollment No',
                'College',
                'State',
                'Company',
                'Job Title',
                'Job Type',
                'Package (INR)',
                'Placement Year',
                'Multiple Offer',
                'Recorded On',
            ]);

            $records = PlacementRecord::with([
                'student.user',
                'student.college.state',
                'company',
            ])->orderBy('created_at', 'desc')->get();

            foreach ($records as $r) {
                $jobTitle = $r->job_id ? (\App\Models\Job::find($r->job_id)?->title ?? '—') : '—';
                $studentName = $r->student->user->name ?? '—';
                $enrollment = $r->student->enrollment_no ?? '—';
                $collegeName = $r->student->college->name ?? '—';
                $stateName = $r->student->college->state->name ?? '—';
                $companyName = $r->company->name ?? '—';

                fputcsv($out, [
                    $r->id,
                    $studentName,
                    $enrollment,
                    $collegeName,
                    $stateName,
                    $companyName,
                    $jobTitle,
                    $r->job_type,
                    $r->package,
                    $r->placement_year,
                    $r->is_multiple_offer ? 'Yes' : 'No',
                    $r->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}