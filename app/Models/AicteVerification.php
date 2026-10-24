<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AicteVerification extends Model {
    protected $fillable = ['college_id', 'certificate_url', 'registration_number', 'verification_method', 'status', 'verified_by', 'verified_at', 'remarks'];
    protected $casts = ['verified_at' => 'datetime'];

    public function college() { return $this->belongsTo(College::class); }
}
