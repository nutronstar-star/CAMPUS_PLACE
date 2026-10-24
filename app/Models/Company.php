<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Company extends Model {
    use SoftDeletes;
    protected $fillable = ['uuid', 'user_id', 'name', 'website', 'industry', 'hr_name', 'hr_email', 'hr_phone', 'logo', 'description', 'status', 'global_approved_by', 'global_approved_at'];
    
    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) { $model->uuid = (string) Str::uuid(); }
        });
    }
    
    public function user() { return $this->belongsTo(User::class); }
    public function jobs() { return $this->hasMany(Job::class); }
}
