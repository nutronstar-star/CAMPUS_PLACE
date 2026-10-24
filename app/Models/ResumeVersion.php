<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ResumeVersion extends Model {
    protected $fillable = ['student_id', 'resume_url', 'version', 'is_default'];
    public function student() { return $this->belongsTo(Student::class); }
}
