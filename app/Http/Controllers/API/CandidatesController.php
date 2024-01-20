<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{
    public function index()
    {
        $candidates = auth()->user()->candidates;
        return response()->json([
            'message' => 'Candidates fetched successfully',
            'candidates' => $candidates
        ], 200);
    }


    public function store()
{
    $this->validate(request(), [
        'name' => 'required',
        'email' => 'required|email',
        'mobile' => 'required',
        'dob' => 'required|date',
        
    ]);

    $candidate = auth()->user()->candidates()->create([
        'name' => request('name'),
        'email' => request('email'),
        'mobile' => request('mobile'),
        'dob' => request('dob'),
        
    ]);

    return response()->json([
        'message' => 'Candidate created successfully',
        'candidate' => $candidate
    ], 201);
}
}


