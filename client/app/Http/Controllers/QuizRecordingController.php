<?php

namespace App\Http\Controllers;

use App\Models\QuizRecording;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class QuizRecordingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'video_path' => 'required|string',
            'started_at' => 'required|date',
            'ended_at' => 'required|date'
        ]);

        try {
            // Create a new recording record
            $recording = QuizRecording::create([
                'user_id' => auth()->id(),
                'test_id' => $request->test_id,
                'video_path' => $request->video_path,
                'started_at' => $request->started_at,
                'ended_at' => $request->ended_at
            ]);

            // Move the video file to the storage directory
            $sourcePath = $request->video_path;
            $destinationPath = 'recordings/' . basename($sourcePath);
            
            if (file_exists($sourcePath)) {
                // Create the recordings directory if it doesn't exist
                Storage::makeDirectory('recordings');
                
                // Move the file to storage
                Storage::put($destinationPath, file_get_contents($sourcePath));
                
                // Update the video path in the database
                $recording->update(['video_path' => $destinationPath]);
                
                // Delete the original file
                unlink($sourcePath);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Recording stored successfully',
                'data' => $recording
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing recording: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store recording: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getRecording($testId)
    {
        $recording = QuizRecording::where('test_id', $testId)
            ->where('user_id', auth()->id())
            ->first();

        if (!$recording) {
            return response()->json([
                'status' => 'error',
                'message' => 'Recording not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $recording
        ]);
    }
}