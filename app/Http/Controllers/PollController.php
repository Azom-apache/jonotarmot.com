<?php

namespace App\Http\Controllers;

use App\Models\PollQuestion;
use App\Models\PollOption;
use App\Models\PollVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use GuzzleHttp\Client;

class PollController extends Controller
{
    public function index()
    {
        
        $polls = PollQuestion::with('options.votes')->get();

    // Iterate through each poll and calculate vote percentages for options
        foreach ($polls as $poll) {
            $totalVotes = $poll->votes()->count(); // Get the total number of votes for the poll

            // Calculate vote percentage for each option
            foreach ($poll->options as $option) {
                $optionVotes = $option->votes()->count(); // Number of votes for this option
                // Calculate the percentage for this option
                $option->percentage = $totalVotes > 0 ? round(($optionVotes / $totalVotes) * 100, 2) : 0;
            }
        }
    
        return view('poll.index', compact('polls'));
    }

    public function create()
    {
        return view('poll.create');
    }

    public function store(Request $request)
    {
        $admin = auth()->user();
        $user = $admin->user;
        $poll = PollQuestion::create([
            'user_id' => $user->id, // Add the user_id to the poll
            'title' => $request->title,
            'is_private' => $request->is_private,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
    
        // Loop through the options and create them for the poll
        foreach ($request->options as $option) {
            PollOption::create([
                'question_id' => $poll->id,
                'option' => $option
            ]);
        }
    
        return redirect()->route('polls.index')->with('success', 'Poll created successfully!');
    }

    public function edit($id)
    {
        $poll = PollQuestion::findOrFail($id);
        return view('poll.edit', compact('poll'));
    }

    public function update(Request $request, $id)
    {
        $poll = PollQuestion::findOrFail($id);
        $poll->update($request->only('title', 'is_private', 'start_time', 'end_time'));

        $poll->options()->delete(); // Delete existing options
        foreach ($request->options as $option) {
            PollOption::create([
                'question_id' => $poll->id,
                'option' => $option
            ]);
        }

        return redirect()->route('polls.index')->with('success', 'Poll updated successfully!');
    }

    public function destroy($id)
    {
        $poll = PollQuestion::findOrFail($id);
        $poll->delete();

        return redirect()->route('polls.index')->with('success', 'Poll deleted successfully!');
    }

    public function homePage()
    {
        // Fetch polls that are open and valid for the current date
        $currentDate = now();
        $polls = PollQuestion::where('status', 'open')
            ->with('PollOption') // Eager load options
            ->get();

        return view('index', compact('polls'));
    }
        public function showPollDetails(Request $request, $id)
    {
        $ipAddress = $request->ip();
        $localIp = $request->input('local_ip', null);  // Accept local IP from request

        $userAgent = $request->header('User-Agent');
        $poll = PollQuestion::with('options.votes')->findOrFail($id);

        $hasVoted = PollVote::where('question_id', $poll->id)
            ->where('ip_address', $ipAddress)
            ->when($localIp, function ($query) use ($localIp) {
                $query->where('local_ip_address', $localIp);  // Use the local IP only if it's available
            })
            ->exists();

        $totalVotes = $poll->votes()->count();

        // Get vote count for each option
        $optionVotes = [];
        foreach ($poll->options as $option) {
            $optionVotes[$option->id] = $option->votes()->count();
        }

        return view('index', compact('poll', 'totalVotes', 'optionVotes', 'hasVoted'));
    }



    public function submitVote(Request $request, $id)
    {
        $poll = PollQuestion::findOrFail($id);

        if ($poll->max_votes > 0 && $poll->votes()->count() >= $poll->max_votes) {
            return redirect()->back()->with('error', 'Vote limit reached for this poll.');
        }

      
        $ipAddress = $request->ip();
        $localIp = $request->input('local_ip');
        $existingVote = PollVote::where('question_id', $poll->id)
            ->where('ip_address', $ipAddress)
            ->first();

        if ($existingVote) {
            return redirect()->back()->with('error', 'You have already voted on this poll.');
        }

        // Store the vote
        PollVote::create([
            'question_id' => $poll->id,
            'option_id' => $request->input('option_id'),
            'ip_address' =>  $ipAddress,
            'local_ip_address'=>$localIp,
        ]);

        return redirect()->back()->with('success', 'Thank you for voting!');
    }
}
