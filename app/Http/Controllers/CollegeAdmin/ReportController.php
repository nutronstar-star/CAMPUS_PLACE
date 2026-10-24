<?php
namespace App\Http\Controllers\CollegeAdmin;

use App\Http\Controllers\Controller;
use App\Models\PlacementRecord;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $admin = auth()->user()->collegeAdminProfile;
        if (!$admin) { abort(403, 'College Admin profile not found.'); }
        $collegeId = $admin->college_id;

        $year = $request->input('year'); // null = all years
        [$stats, $deptStats, $companyStats, $placements, $years] = $this->buildStats($collegeId, $year);

        return view('college-admin.reports.index', compact(
            'stats', 'deptStats', 'companyStats', 'placements', 'years', 'year'
        ));
    }

    public function exportPlacements(Request $request)
    {
        $admin = auth()->user()->collegeAdminProfile;
        if (!$admin) { abort(403); }
        $collegeId = $admin->college_id;
        $year = $request->input('year');

        [, , , $placements] = $this->buildStats($collegeId, $year);
        $filename = 'college-' . $collegeId . '-placement-records-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($placements) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'Student Name', 'Enrollment', 'Department', 'Company',
                'Job Title', 'Job Type', 'Package (INR)', 'Year', 'Multiple Offer', 'Recorded On',
            ]);

            foreach ($placements as $p) {
                fputcsv($out, [
                    $p->student->user->name ?? '—',
                    $p->student->enrollment_no ?? '—',
                    $p->student->department->name ?? '—',
                    $p->company->name ?? '—',
                    $p->job->title ?? '—',
                    $p->job_type,
                    $p->package,
                    $p->placement_year,
                    $p->is_multiple_offer ? 'Yes' : 'No',
                    $p->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function exportDepartments(Request $request)
    {
        $admin = auth()->user()->collegeAdminProfile;
        if (!$admin) { abort(403); }
        $collegeId = $admin->college_id;
        $year = $request->input('year');

        [, $deptStats] = $this->buildStats($collegeId, $year);
        $filename = 'college-' . $collegeId . '-department-summary-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($deptStats) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, ['Department', 'Total Students', 'Placed', 'Placement Rate (%)']);
            foreach ($deptStats as $d) {
                fputcsv($out, [$d['name'], $d['total'], $d['placed'], $d['rate']]);
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function buildStats($collegeId, $year)
    {
        $placementsQuery = PlacementRecord::where('college_id', $collegeId)
            ->with(['student.user', 'student.department', 'company', 'job'])
            ->orderBy('created_at', 'desc');

        if ($year) {
            $placementsQuery->where('placement_year', $year);
        }

        $placements = $placementsQuery->get();

        $totalStudents = Student::where('college_id', $collegeId)->count();
        $totalPlaced = $placements->count();
        $placementRate = $totalStudents > 0 ? round(($totalPlaced / $totalStudents) * 100, 2) : 0;

        $packages = $placements->pluck('package')->filter()->sort()->values();
        $highest = $packages->max() ?? 0;
        $average = $packages->count() > 0 ? round($packages->avg(), 2) : 0;
        $median = 0;
        if ($packages->count() > 0) {
            $c = $packages->count();
            $m = intdiv($c, 2);
            $median = ($c % 2 === 0) ? round(($packages[$m - 1] + $packages[$m]) / 2, 2) : $packages[$m];
        }

        $stats = [
            'total_students' => $totalStudents,
            'placed_students' => $totalPlaced,
            'placement_rate' => $placementRate,
            'highest_package' => $highest,
            'average_package' => $average,
            'median_package' => $median,
        ];

        $deptStats = Department::where('college_id', $collegeId)->get()->map(function ($d) use ($collegeId, $placements) {
            $total = Student::where('college_id', $collegeId)->where('department_id', $d->id)->count();
            $placed = $placements->filter(fn ($p) => $p->student && $p->student->department_id === $d->id)->count();
            return [
                'name' => $d->name,
                'code' => $d->code,
                'total' => $total,
                'placed' => $placed,
                'rate' => $total > 0 ? round(($placed / $total) * 100, 2) : 0,
            ];
        });

        $companyStats = $placements->groupBy(fn ($p) => $p->company->name ?? 'Unknown')
            ->map(fn ($rows, $name) => [
                'name' => $name,
                'hires' => $rows->count(),
                'avg_package' => round($rows->avg('package'), 2),
            ])
            ->sortByDesc('hires')
            ->values();

        $years = PlacementRecord::where('college_id', $collegeId)
            ->distinct()
            ->orderByDesc('placement_year')
            ->pluck('placement_year');

        return [$stats, $deptStats, $companyStats, $placements, $years];
    }
}