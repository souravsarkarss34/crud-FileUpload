<?php

namespace App\Models;
use App\Models\Subject;
use App\Models\Std;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'standard', 'capacity', 'subjects', 'teacher'];

    // protected $primaryKey = 'id';
    public function studentClass()
    {
        return $this->belongsTo(Std::class, 'standard', 'standard');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'detailable');
    }
}