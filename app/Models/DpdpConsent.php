<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DpdpConsent extends Model {
    protected $fillable = ['user_id', 'consent_type', 'consented', 'ip_address', 'consented_at'];
    protected $casts = ['consented_at' => 'datetime'];
}
