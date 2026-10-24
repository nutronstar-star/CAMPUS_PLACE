<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    protected $fillable = ['user_id', 'college_id', 'title', 'message', 'type', 'channel', 'is_critical', 'read_status'];
    
    public function user() { return $this->belongsTo(User::class); }
}
