@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Polls</h2>
        <a href="{{ route('polls.create') }}" class="btn btn-success mb-3">Create Poll</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Private</th>
                    <th>Status</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($polls as $poll)
                    <tr>
                        <td>{{ $poll->title }}</td>
                        <td>{{ $poll->is_private ? 'Private' : 'Public' }}</td>
                        <td>{{ $poll->status }}</td>
                        <td>{{ $poll->start_time }}</td>
                        <td>{{ $poll->end_time }}</td>
                        <td>
                            <!-- Button to copy the share link -->
                            <button class="btn btn-primary copy-link" data-url="{{ route('showPollDetails', $poll->id) }}">Copy Share Link</button>
                            
                            <a href="{{ route('polls.edit', $poll->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('polls.destroy', $poll->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            <button class="btn btn-info show-options">Show Options</button>
                        </td>
                    </tr>
                    <tr class="options-row" style="display: none;">
                        <td colspan="6">
                            <ul>
                                @foreach($poll->options as $option)
                                    <li>{{ $option->option }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Toggle options visibility
            $('.show-options').click(function () {
                $(this).closest('tr').next('.options-row').toggle();
            });

            // Copy the share link to clipboard
            $('.copy-link').click(function () {
                var pollUrl = $(this).data('url');

                // Create a temporary input to copy the URL
                var tempInput = $('<input>');
                $('body').append(tempInput);
                tempInput.val(pollUrl).select();
                document.execCommand("copy");
                tempInput.remove();

                alert("Poll link copied to clipboard!");
            });
        });
    </script>
@endsection
