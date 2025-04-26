<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TestSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $test;

    public function __construct($test)
    {
        $this->test = $test;
        Log::info('TestSubmitted event constructed', [
            'test_id' => $test->id,
            'user_id' => $test->user_id
        ]);
    }

    public function broadcastOn()
    {
        Log::info('Broadcasting on test-submissions channel');
        return new Channel('test-submissions');
    }

    public function broadcastAs()
    {
        return 'test-submitted';
    }

    public function broadcastWith()
    {
        $data = [
            'test_id' => $this->test->id,
            'user_name' => $this->test->user->first_name . ' ' . $this->test->user->last_name,
            'score' => $this->test->total_score,
            'depression_level' => $this->test->depression_level,
            'created_at' => $this->test->created_at->format('F j, Y g:i A')
        ];
        
        Log::info('Broadcasting data', $data);
        return $data;
    }
} 