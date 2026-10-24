<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ApplicationResume extends Model {
    protected $table = 'application_resumes';
    protected $fillable = ['application_id', 'resume_url', 'resume_version'];
    
    public function application() { return $this->belongsTo(Application::class); }
}