<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Student extends Model {
    use SoftDeletes;
    protected $fillable = ['uuid', 'user_id', 'college_id', 'department_id', 'enrollment_no', 'cgpa', 'backlogs', 'passing_year', 'skills', 'bio', 'profile_picture', 'status'];
    protected $casts = ['skills' => 'array'];
    
    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) { $model->uuid = (string) Str::uuid(); }
        });
    }
    
    public function user() { return $this->belongsTo(User::class); }
    public function college() { return $this->belongsTo(College::class); }
    public function department() { return $this->belongsTo(Department::class); }
    public function applications() { return $this->hasMany(Application::class); }
    public function resumes() { return $this->hasMany(ResumeVersion::class); }
}
