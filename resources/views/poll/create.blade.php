@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Poll</h2>

        <form action="{{ route('polls.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Poll Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="is_private">Poll Privacy</label>
                <select name="is_private" class="form-control">
                    <option value="0">Public</option>
                    <option value="1">Private</option>
                </select>
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control">
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="datetime-local" name="end_time" class="form-control">
            </div>

            <div class="form-group">
                <label for="max_votes">Max Votes</label>
                <input type="number" name="max_votes" class="form-control" placeholder="Optional">
            </div>

            <div class="form-group">
                <label>Poll Options</label>
                <table class="table" id="poll-options">
                    <tr>
                        <td><input type="text" name="options[]" class="form-control" required></td>
                        <td><button type="button" class="btn btn-success add-row">Add Option</button></td>
                    </tr>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Create Poll</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.add-row').click(function () {
                $('#poll-options').append('<tr><td><input type="text" name="options[]" class="form-control" required></td><td><button type="button" class="btn btn-danger remove-row">Remove</button></td></tr>');
            });

            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endsection
