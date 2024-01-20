<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = ['criteria_text', 'user_id', 'criteria_type'];

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class)->withPivot('response');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
