<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BlacklistCollege extends Model {
    protected $fillable = ['college_id', 'reason', 'blacklisted_by'];
    public function college() { return $this->belongsTo(College::class); }
}
