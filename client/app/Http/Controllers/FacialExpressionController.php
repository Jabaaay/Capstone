<?php

namespace App\Http\Controllers;

use App\Models\FacialExpression;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacialExpressionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'expression' => 'required|string',
            'confidence' => 'required|numeric'
        ]);

        $expression = FacialExpression::create([
            'user_id' => Auth::id(),
            'test_id' => $request->test_id,
            'expression' => $request->expression,
            'confidence' => $request->confidence
        ]);

        return response()->json($expression);
    }

    public function getMostFrequentExpression($testId)
    {
        $expressions = FacialExpression::where('test_id', $testId)
            ->select('expression', \DB::raw('count(*) as count'))
            ->groupBy('expression')
            ->orderBy('count', 'desc')
            ->first();

        return response()->json($expressions);
    }
} 