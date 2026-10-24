<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model {
    protected $fillable = ['application_id', 'round_number', 'round_name', 'mode', 'scheduled_at', 'duration_minutes', 'venue', 'meeting_link', 'result', 'feedback'];
    protected $casts = ['scheduled_at' => 'datetime'];

    public function application() { return $this->belongsTo(Application::class); }
}
