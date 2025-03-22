<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $messages = Message::where('recipient_id', $user->id)
                           ->orWhere('sender_id', $user->id)
                           ->latest()
                           ->paginate(10);

        return view('candidate.messages', compact('messages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'recipient_id' => ['required', 'exists:users,id'],
            'content' => ['required', 'string', 'max:2000'],
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->sentMessages()->create([
            'recipient_id' => $request->recipient_id,
            'content' => $request->content,
        ]);

        return redirect()->route('candidate.messages.index')->with('status', 'Message sent!');
    }
}