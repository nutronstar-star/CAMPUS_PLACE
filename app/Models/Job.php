<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Job extends Model {
    protected $fillable = ['uuid', 'company_id', 'title', 'description', 'job_type', 'package_min', 'package_max', 'stipend', 'location', 'eligibility', 'deadline', 'status'];
    
    protected $casts = ['eligibility' => 'array', 'deadline' => 'datetime'];
    
    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) { $model->uuid = (string) Str::uuid(); }
        });
    }
    
    public function company() { return $this->belongsTo(Company::class); }
    public function applications() { return $this->hasMany(Application::class); }
    public function colleges() { return $this->belongsToMany(College::class, 'job_colleges')->withPivot('approval_status'); }
}
