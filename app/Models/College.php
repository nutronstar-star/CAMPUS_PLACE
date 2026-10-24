<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class College extends Model {
    use SoftDeletes;
    protected $fillable = ['uuid', 'state_id', 'name', 'code', 'email', 'phone', 'website', 'address', 'city', 'pincode', 'principal_name', 'tpo_name', 'tpo_contact', 'total_students', 'naac_grade', 'status', 'verified_by', 'verified_at'];
    
    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) { $model->uuid = (string) Str::uuid(); }
        });
    }
    
    public function state() { return $this->belongsTo(State::class); }
    public function students() { return $this->hasMany(Student::class); }
    public function departments() { return $this->hasMany(Department::class); }
    public function admins() { return $this->hasMany(CollegeAdmin::class); }
    public function aicteVerifications() { return $this->hasMany(AicteVerification::class); }
}

