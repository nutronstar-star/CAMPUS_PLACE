<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PlacementRecord extends Model {
    protected $fillable = ['student_id', 'company_id', 'job_id', 'college_id', 'state_id', 'package', 'job_type', 'placement_year', 'is_multiple_offer'];
    public function student() { return $this->belongsTo(Student::class); }
    public function company() { return $this->belongsTo(Company::class); }
}
