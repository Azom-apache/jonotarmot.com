@extends('admin/layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Employee Management</h2>
    
    <!-- Success Message -->
    @if ($message = Session::get('success'))
        <div class="alert alert-info text-white">
            <p>{{ $message }}</p>
        </div>
    @endif

    <!-- Add Employee Button -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEmployeeModal">
        Add Employee
    </button>

    <!-- Employee Table -->
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Photo</th>
            <th>Designation</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->address }}</td>
                <td><img src="{{ asset($employee->photo) }}" alt="Employee Photo" style="max-width: 100px; max-height: 100px;"></td>
                <td>{{ $employee->designation }}</td>
                <td>{{ $employee->phone }}</td>
                <td>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#showEmployeeModal{{ $employee->id }}">
                        Show
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editEmployeeModal{{ $employee->id }}">
                        Edit
                    </button>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
<!-- Edit Modal -->
<div class="modal fade" id="editEmployeeModal{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModal{{ $employee->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModal{{ $employee->id }}Label">Edit Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Existing fields -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $employee->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="Male" {{ $employee->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $employee->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ $employee->gender == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" value="{{ $employee->birthday }}">
                    </div>
                    <div class="form-group">
                        <label for="nid">NID</label>
                        <input type="text" class="form-control" id="nid" name="nid" value="{{ $employee->nid }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $employee->address }}">
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control-file" id="photo" name="photo">
                        @if ($employee->photo)
                            <img src="{{ asset($employee->photo) }}" alt="Employee Photo" class="img-fluid mt-2" style="max-width: 200px;">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="branch_id">Branch</label>
                        <select class="form-control" id="branch_id" name="branch_id">
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{ $employee->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="designation">Designation</label>
                        <input type="text" class="form-control" id="designation" name="designation" value="{{ $employee->designation }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $employee->phone }}">
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="number" class="form-control" id="salary" name="salary" step="0.01" value="{{ $employee->salary }}">
                    </div>
                    <div class="form-group">
                        <label for="eSalaryAcc">eSalaryAcc</label>
                        <input type="text" class="form-control" id="eSalaryAcc" name="eSalaryAcc" value="{{ $employee->eSalaryAcc }}">
                    </div>
                    <div class="form-group">
                        <label for="payLeave">Pay Leave</label>
                        <input type="number" class="form-control" id="payLeave" name="payLeave" value="{{ $employee->payLeave }}">
                    </div>
                    <div class="form-group">
                        <label for="npayLeave">Non-Pay Leave</label>
                        <input type="number" class="form-control" id="npayLeave" name="npayLeave" value="{{ $employee->npayLeave }}">
                    </div>
                    <div class="form-group">
                        <label for="evmoSalarydate">Salary Date</label>
                        <input type="date" class="form-control" id="evmoSalarydate" name="evmoSalarydate" value="{{ $employee->evmoSalarydate }}">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="Active" {{ $employee->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $employee->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="On Leave" {{ $employee->status == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="joinDate">Join Date</label>
                        <input type="date" class="form-control" id="joinDate" name="joinDate" value="{{ $employee->joinDate }}">
                    </div>
                    <div class="form-group">
                        <label for="joinTime">Join Time</label>
                        <input type="time" class="form-control" id="joinTime" name="joinTime" value="{{ $employee->joinTime }}">
                    </div>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" id="author" name="author" value="{{ $employee->author }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

            <!-- Show Employee Modal -->
            <div class="modal fade" id="showEmployeeModal{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="showEmployeeModalLabel{{ $employee->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="showEmployeeModalLabel{{ $employee->id }}">Employee Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <p><strong>Photo:</strong> <img src="{{ asset($employee->photo) }}" alt="Employee Photo" style="max-width: 100px; max-height: 100px;"></p>
                            <p><strong>Name:</strong> {{ $employee->name }}</p>
                            <p><strong>Gender:</strong> {{ $employee->gender }}</p>
                            <p><strong>Birthday:</strong> {{ $employee->birthday }}</p>
                            <p><strong>NID:</strong> {{ $employee->nid }}</p>
                            <p><strong>Address:</strong> {{ $employee->address }}</p>
                            
                            <p><strong>Branch ID:</strong> {{optional($employee->branch)->name }}</p>
                            <p><strong>Designation:</strong> {{ $employee->designation }}</p>
                            <p><strong>Phone:</strong> {{ $employee->phone }}</p>
                            <p><strong>Salary:</strong> {{ $employee->salary }}</p>
                            <p><strong>eSalaryAcc:</strong> {{ $employee->eSalaryAcc }}</p>
                            <p><strong>Pay Leave:</strong> {{ $employee->payLeave }}</p>
                            <p><strong>Non-Pay Leave:</strong> {{ $employee->npayLeave }}</p>
                            <p><strong>Salary Date:</strong> {{ $employee->evmoSalarydate }}</p>
                            <p><strong>Status:</strong> {{ $employee->status }}</p>
                            <p><strong>Join Date:</strong> {{ $employee->joinDate }}</p>
                            <p><strong>Join Time:</strong> {{ $employee->joinTime }}</p>
                            <p><strong>Author:</strong> {{ $employee->author }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>


<!-- Add Employee Modal -->
<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Form Fields -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" class="form-control" name="birthday">
                    </div>
                    <div class="form-group">
                        <label for="nid">NID</label>
                        <input type="text" class="form-control" name="nid">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address">
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control" name="photo">
                    </div>
                    <div class="form-group">
                        <label for="branch_id">Branch</label>
                        <select class="form-control" name="branch_id" required>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="designation">Designation</label>
                        <input type="text" class="form-control" name="designation">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="number" class="form-control" name="salary" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="eSalaryAcc">eSalaryAcc</label>
                        <input type="text" class="form-control" name="eSalaryAcc">
                    </div>
                    <div class="form-group">
                        <label for="payLeave">Pay Leave</label>
                        <input type="number" class="form-control" name="payLeave" value="0">
                    </div>
                    <div class="form-group">
                        <label for="npayLeave">Non-Pay Leave</label>
                        <input type="number" class="form-control" name="npayLeave" value="0">
                    </div>
                    <div class="form-group">
                        <label for="evmoSalarydate">Salary Date</label>
                        <input type="date" class="form-control" name="evmoSalarydate">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="On Leave">On Leave</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="joinDate">Join Date</label>
                        <input type="date" class="form-control" name="joinDate">
                    </div>
                    <div class="form-group">
                        <label for="joinTime">Join Time</label>
                        <input type="time" class="form-control" name="joinTime">
                    </div>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" name="author">
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


@endsection