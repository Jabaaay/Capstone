<?php

namespace App\Http\Controllers;

use App\Models\FacialExpression;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacialExpressionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'expression' => 'required|string',
                'confidence' => 'required|numeric',
                'test_id' => 'required|exists:tests,id',
                'user_id' => 'required|exists:users,id'
            ]);

            // Get the test to verify user ownership
            $test = Test::findOrFail($request->test_id);
            
            // Verify that the test belongs to the authenticated user
            if ($test->user_id !== $request->user_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized: Test does not belong to the specified user'
                ], 403);
            }

            $expression = FacialExpression::create([
                'user_id' => $request->user_id,
                'test_id' => $request->test_id,
                'expression' => $request->expression,
                'confidence' => $request->confidence
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Facial expression stored successfully',
                'data' => $expression
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store facial expression: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getMostFrequentExpression($testId)
    {
        try {
            $expressions = FacialExpression::where('test_id', $testId)
                ->select('expression', \DB::raw('count(*) as count'))
                ->groupBy('expression')
                ->orderBy('count', 'desc')
                ->first();

            if (!$expressions) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No expressions found for this test'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $expressions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get most frequent expression: ' . $e->getMessage()
            ], 500);
        }
    }
} 