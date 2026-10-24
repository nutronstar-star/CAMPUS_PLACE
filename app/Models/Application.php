<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Application extends Model {
    protected $fillable = ['uuid', 'student_id', 'job_id', 'college_id', 'status'];
    
    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) { $model->uuid = (string) Str::uuid(); }
        });
    }
    
    public function student() { return $this->belongsTo(Student::class); }
    public function job() { return $this->belongsTo(Job::class); }
    public function college() { return $this->belongsTo(College::class); }
    public function resume() { return $this->hasOne(ApplicationResume::class); }
    public function interviews() { return $this->hasMany(Interview::class); }
}
