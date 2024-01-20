<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index()
    {

        $criteria = auth()->user()->criteria;
        return response()->json([
            'message' => 'Criteria fetched successfully',
            'criteria' => $criteria
        ], 200);
    }

    public function store(Request $request)
    {

        $request->validate([
            'criteria_text' => ['required'],
            'criteria_type' => ['required', 'in:1,2', 'numeric']
        ]);
        $criteria = auth()->user()->criteria()->create([
            'criteria_text' => $request->criteria_text,
            'criteria_type' => $request->criteria_type
        ]);
        $criteria->save();
        return response()->json([
            'message' => 'Criteria created successfully',
            'criteria' => $criteria
        ], 201);
    }
}
