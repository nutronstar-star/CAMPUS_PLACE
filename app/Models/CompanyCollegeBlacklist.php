<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CompanyCollegeBlacklist extends Model {
    protected $table = 'company_college_blacklist';
    protected $fillable = ['company_id', 'college_id', 'reason', 'blacklisted_by'];
    public function company() { return $this->belongsTo(Company::class); }
    public function college() { return $this->belongsTo(College::class); }
}
