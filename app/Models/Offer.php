<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Offer extends Model {
    protected $fillable = ['uuid', 'student_id', 'company_id', 'job_id', 'college_id', 'package', 'offer_letter_url', 'acceptance_deadline', 'status', 'responded_at'];
    
    protected $casts = ['acceptance_deadline' => 'datetime', 'responded_at' => 'datetime'];

    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) { $model->uuid = (string) Str::uuid(); }
        });
    }
    
    public function student() { return $this->belongsTo(Student::class); }
    public function company() { return $this->belongsTo(Company::class); }
    public function job() { return $this->belongsTo(Job::class); }
}
