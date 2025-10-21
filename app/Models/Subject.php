<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'schedule'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'subject_user');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
