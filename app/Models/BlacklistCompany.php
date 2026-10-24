<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BlacklistCompany extends Model {
    protected $fillable = ['company_id', 'reason', 'scope', 'college_id', 'blacklisted_by'];
    public function company() { return $this->belongsTo(Company::class); }
}
