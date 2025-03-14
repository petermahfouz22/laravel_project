<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentModerationController extends Controller
{
    /**
     * Constructor - Apply admin middleware
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    /**
     * Manage pending comments
     */
    public function pendingComments()
    {
        $pendingComments = Comment::where('is_approved', false)
            ->with(['commentable', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.comments.pending', compact('pendingComments'));
    }
    
    /**
     * Approve a comment
     */
    public function approveComment(Comment $comment)
    {
        $comment->is_approved = true;
        $comment->save();
        
        return redirect()->back()
            ->with('success', 'Comment approved successfully.');
    }
    
    /**
     * Reject a comment
     */
    public function rejectComment(Comment $comment)
    {
        $comment->delete();
        
        return redirect()->back()
            ->with('success', 'Comment rejected and removed successfully.');
    }
    
    /**
     * View all comments
     */
    public function allComments(Request $request)
    {
        $query = Comment::query()->with(['commentable', 'user']);
        
        // Filter by approval status if provided
        if ($request->has('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }
        
        $comments = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.comments.index', compact('comments'));
    }
    
    /**
     * Generate applications report
     */
    public function applicationsReport($period = 'month')
    {
        // Define date range based on period
        $startDate = $this->getStartDateForPeriod($period);
        
        // Get applications count by date
        $applicationsData = Application::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
            
        // Get applications by status
        $statusData = Application::where('created_at', '>=', $startDate)
            ->select(
                'status',
                DB::raw('count(*) as count')
            )
            ->groupBy('status')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
            
        return [
            'timeSeriesData' => $applicationsData,
            'statusData' => $statusData,
        ];
    }
    
    /**
     * Get comment statistics 
     */
    public function commentStats($period = 'month')
    {
        // Define date range based on period
        $startDate = $this->getStartDateForPeriod($period);
        
        // Get comments by approval status
        $approvalData = Comment::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('is_approved'),
                DB::raw('count(*) as count')
            )
            ->groupBy('is_approved')
            ->get()
            ->pluck('count', 'is_approved')
            ->toArray();
        
        // Map boolean keys to more readable status
        $statusMap = [
            '0' => 'Pending',
            '1' => 'Approved'
        ];
        
        $formattedData = [];
        foreach ($approvalData as $key => $value) {
            $formattedData[$statusMap[$key]] = $value;
        }
        
        return $formattedData;
    }
    
    /**
     * Get start date based on period
     */
    private function getStartDateForPeriod($period)
    {
        switch ($period) {
            case 'week':
                return Carbon::now()->subDays(7);
            case 'month':
                return Carbon::now()->subDays(30);
            case 'quarter':
                return Carbon::now()->subMonths(3);
            case 'year':
                return Carbon::now()->subYear();
            default:
                return Carbon::now()->subDays(30);
        }
    }
    
    /**
     * Flag comment as inappropriate
     */
    public function flagComment(Comment $comment)
    {
        $comment->is_flagged = true;
        $comment->save();
        
        return redirect()->back()
            ->with('success', 'Comment has been flagged for review.');
    }
    
    /**
     * Review flagged comments
     */
    public function flaggedComments()
    {
        $flaggedComments = Comment::where('is_flagged', true)
            ->with(['commentable', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.comments.flagged', compact('flaggedComments'));
    }
    
    /**
     * Clear flag from comment
     */
    public function clearFlag(Comment $comment)
    {
        $comment->is_flagged = false;
        $comment->save();
        
        return redirect()->back()
            ->with('success', 'Flag removed from comment.');
    }
    
    /**
     * Bulk approve comments
     */
    public function bulkApprove(Request $request)
    {
        $validated = $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id'
        ]);
        
        Comment::whereIn('id', $validated['comment_ids'])
            ->update(['is_approved' => true]);
            
        return redirect()->back()
            ->with('success', 'Selected comments have been approved.');
    }
    
    /**
     * Bulk reject comments
     */
    public function bulkReject(Request $request)
    {
        $validated = $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id'
        ]);
        
        Comment::whereIn('id', $validated['comment_ids'])->delete();
            
        return redirect()->back()
            ->with('success', 'Selected comments have been rejected and removed.');
    }
}