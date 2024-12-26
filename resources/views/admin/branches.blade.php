@extends('admin/layouts.app')

@section('content')
<div class="row">
    <div align="left">
        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#addBranchModal">Add branch</button>
    </div>
    <div class="container">
        <table id="plansTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Values</th>
                    <th>Created date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($branches as $branch)
                <tr>
                    <td>{{ $branch->name }}</td>
                    <td>{{ $branch->address }}</td>
                    <td>{{ $branch->phone }}</td>
                    <td>{{ $branch->total_values }}</td>
                    <td>{{ $branch->updated_at }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $branch->id }}" data-name="{{ $branch->name }}" data-address="{{ $branch->address }}" data-phone="{{ $branch->phone }}" data-total_values="{{ $branch->total_values }}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $branch->id }}">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Branch Modal -->
<div class="modal fade" id="addBranchModal" tabindex="-1" role="dialog" aria-labelledby="addBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="addBranchForm" method="POST" action="{{ route('branches.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addBranchModalLabel">Add Branch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="total_values">Values</label>
                        <input type="number" class="form-control" id="total_values" name="total_values" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Branch Modal -->
<div class="modal fade" id="editBranchModal" tabindex="-1" role="dialog" aria-labelledby="editBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editBranchForm" method="POST" action="{{ route('branches.update', ['branch' => 0]) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editBranchModalLabel">Edit Branch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editBranchId" name="id">
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <input type="text" class="form-control" id="editAddress" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="editPhone">Phone</label>
                        <input type="text" class="form-control" id="editPhone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="editTotalValues">Values</label>
                        <input type="number" class="form-control" id="editTotalValues" name="total_values" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Branch Modal -->
<div class="modal fade" id="deleteBranchModal" tabindex="-1" role="dialog" aria-labelledby="deleteBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteBranchForm" method="POST" action="{{ route('branches.destroy', ['branch' => 0]) }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBranchModalLabel">Delete Branch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this branch?</p>
                    <input type="hidden" id="deleteBranchId" name="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#plansTable').DataTable({
        "paging": true,
        "searching": true
    });

    // Handle edit button click
    $('.edit-btn').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var address = $(this).data('address');
        var phone = $(this).data('phone');
        var total_values = $(this).data('total_values');

        $('#editBranchId').val(id);
        $('#editName').val(name);
        $('#editAddress').val(address);
        $('#editPhone').val(phone);
        $('#editTotalValues').val(total_values);

        var action = $('#editBranchForm').attr('action');
        action = action.replace('/0', '/' + id);
        $('#editBranchForm').attr('action', action);

        $('#editBranchModal').modal('show');
    });

    // Handle delete button click
    $('.delete-btn').on('click', function() {
        var id = $(this).data('id');
        $('#deleteBranchId').val(id);

        var action = $('#deleteBranchForm').attr('action');
        action = action.replace('/0', '/' + id);
        $('#deleteBranchForm').attr('action', action);

        $('#deleteBranchModal').modal('show');
    });
});
</script>
@endsection
