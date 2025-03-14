<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Job $job)
    {
        // Validate request
        $validated = $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        // Create comment
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->content = $validated['content'];
        $comment->is_approved = Auth::user()->role === 'admin' ? true : false;
        
        // Save comment using polymorphic relationship
        $job->comments()->save($comment);

        return redirect()->back()
            ->with('success', Auth::user()->role === 'admin' ? 'Comment added successfully.' : 'Your comment has been submitted and is awaiting approval.');
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        // Check authorization
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            return redirect()->back()
                ->with('error', 'You are not authorized to update this comment.');
        }

        // Validate request
        $validated = $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        // Update comment
        $comment->content = $validated['content'];
        
        // Reset approval status if not admin
        if (Auth::user()->role !== 'admin') {
            $comment->is_approved = false;
        }
        
        $comment->save();

        return redirect()->back()
            ->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        // Check authorization
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            return redirect()->back()
                ->with('error', 'You are not authorized to delete this comment.');
        }

        // Delete comment
        $comment->delete();

        return redirect()->back()
            ->with('success', 'Comment deleted successfully.');
    }

    /**
     * Toggle comment approval status (admin only).
     */
    public function toggleApproval(Comment $comment)
    {
        // Check authorization
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()
                ->with('error', 'Only administrators can approve comments.');
        }

        // Toggle approval
        $comment->is_approved = !$comment->is_approved;
        $comment->save();

        $status = $comment->is_approved ? 'approved' : 'unapproved';
        return redirect()->back()
            ->with('success', "Comment has been {$status}.");
    }
}