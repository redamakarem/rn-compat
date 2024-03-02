<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
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

    public function update(Request $request)
    {
        $criteria = Criteria::where('id', $request->criteria_id)
            ->where('user_id', auth()->user()->id)
            ->first();
        if (!$criteria) {
            return response()->json([
                'message' => 'Criteria not found',
                'criteria' => $request->criteria_type
            ], 404);
        }
        $request->validate([
            'criteria_id' => ['required', 'numeric'], // 'criteria_id' => 'required|numeric'
            'criteria_text' => ['required'],
            'criteria_type' => ['required', 'in:1,2', 'numeric']
        ]);
        $criteria->update([
            'criteria_text' => $request->criteria_text,
            'criteria_type' => $request->criteria_type
        ]);
        $criteria->save();
        return response()->json([
            'message' => 'Criteria updated successfully',
            'criteria' => $criteria
        ], 200);
    }

    public function destroy(Request $request)
    {

        $criteria = Criteria::where('id', $request->id)
            ->where('user_id', auth()->user()->id)
            ->first();
        if (!$criteria) {
            return response()->json([
                'message' => 'Criteria not found',
                'criteria' => $request->id
            ], 404);
        }
        $criteria->delete();
        return response()->json([
            'message' => 'Criteria deleted successfully',
            'criteria' => $criteria
        ], 200);
    }
}
