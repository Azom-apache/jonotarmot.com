@extends('admin/layouts.app')

@section('content')
<div class="row">
    <div align="right">
        <a class="btn btn-sm btn-info" href="{{ route('addTranslation') }}">Add Translations</a>
    </div>
    <div class="container">
        <table id="transTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>English</th>
                    <th>Translation</th>
                    <th>Language Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trans as $tran)
                <tr>
                    <td style="white-space: pre-wrap;" class="editable-cell" data-field="key_text" data-id="{{ $tran->id }}">{{ $tran->key_text }}</td>
                    <td style="white-space: pre-wrap;" class="editable-cell" data-field="translate" data-id="{{ $tran->id }}">{{ $tran->translate }}</td>
                    <td>{{ $tran->lang }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary btn-remove" data-id="{{ $tran->id }}">Remove</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#transTable').DataTable({
        "paging": true,
        "searching": true
    });

    // Double click event to make cells editable
    $('#transTable').on('dblclick', '.editable-cell', function() {
        var originalContent = $(this).text().trim();
        $(this).attr('contenteditable', 'true').focus();

        $(this).on('blur', function() {
            var newText = $(this).text().trim();
            var field = $(this).data('field');
            var id = $(this).data('id');

            if (newText !== originalContent) {
                updateTranslation(field, newText, id);
            }

            $(this).removeAttr('contenteditable');
        });
    });

    // Handle remove button click
    $('#transTable').on('click', '.btn-remove', function() {
        var id = $(this).data('id');
        var confirmation = confirm('Are you sure you want to delete this translation?');

        if (confirmation) {
            removeTranslation(id);
        }
    });

    // Function to remove translation via Ajax
    function removeTranslation(id) {
        $.ajax({
            url: '{{ route("remove.translation") }}',
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function(response) {
                console.log('Translation removed successfully');
                window.location.reload(); // Reload the entire page
            },
            error: function(xhr, status, error) {
                console.error('Error removing translation:', error);
                alert('Failed to remove translation. Please try again.'); // Notify the user of the error
            }
        });

    }

    // Function to update translation via Ajax
    function updateTranslation(field, newText, id) {
        $.ajax({
            url: '{{ route("update.translation") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                field: field,
                text: newText,
                id: id
            },
            success: function(response) {
                console.log('Translation updated successfully');
                // Optionally, update the UI or notify the user
            },
            error: function(xhr, status, error) {
                console.error('Error updating translation:', error);
                // Handle errors or notify the user
            }
        });
    }
});
</script>
@endsection
