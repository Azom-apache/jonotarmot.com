@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Poll</h2>

        <form action="{{ route('polls.update', $poll->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Poll Title</label>
                <input type="text" name="title" class="form-control" value="{{ $poll->title }}" required>
            </div>

            <div class="form-group">
                <label for="is_private">Poll Privacy</label>
                <select name="is_private" class="form-control">
                    <option value="0" {{ $poll->is_private == 0 ? 'selected' : '' }}>Public</option>
                    <option value="1" {{ $poll->is_private == 1 ? 'selected' : '' }}>Private</option>
                </select>
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control" value="{{ $poll->start_time }}">
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="datetime-local" name="end_time" class="form-control" value="{{ $poll->end_time }}">
            </div>

            <div class="form-group">
                <label>Poll Options</label>
                <table class="table" id="poll-options">
                    @foreach($poll->options as $option)
                        <tr>
                            <td><input type="text" name="options[]" class="form-control" value="{{ $option->option }}" required></td>
                            <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                        </tr>
                    @endforeach
                </table>
                <button type="button" class="btn btn-success add-row">Add Option</button>
            </div>

            <button type="submit" class="btn btn-primary">Update Poll</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.add-row').click(function () {
                $('#poll-options').append('<tr><td><input type="text" name="options[]" class="form-control"></td><td><button type="button" class="btn btn-danger remove-row">Remove</button></td></tr>');
            });

            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endsection
