<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = ['criteria_text'];

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class)->withPivot('response');
    }
}
