<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['name','email','mobile','dob','user_id','candidate_image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function criterias()
    {
        return $this->belongsToMany(Criteria::class)->withPivot('response');
    }


    public function getCandidateImageUrlAttribute()
{
    return $this->candidate_image ? Storage::url($this->candidate_image) : null;
}


    public function getHoroscopeAttribute()
    {
        $date = $this->dob;
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));

    if (($month == 1 && $day <= 19) || ($month == 12 && $day >= 22)) {
        return 'Capricorn';
    } elseif (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) {
        return 'Aquarius';
    } elseif (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) {
        return 'Pisces';
    } elseif (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) {
        return 'Aries';
    } elseif (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) {
        return 'Taurus';
    } elseif (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) {
        return 'Gemini';
    } elseif (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) {
        return 'Cancer';
    } elseif (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) {
        return 'Leo';
    } elseif (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) {
        return 'Virgo';
    } elseif (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) {
        return 'Libra';
    } elseif (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) {
        return 'Scorpio';
    } elseif (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) {
        return 'Sagittarius';
    }
        
    }
}
