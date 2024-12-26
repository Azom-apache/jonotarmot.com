<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $branches = Branch::all();
        return view('admin.employee', compact('employees','branches'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'gender' => 'required|string',
        'birthday' => 'nullable|date',
        'nid' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'photo' => 'nullable|image|max:2048',
        'branch_id' => 'required|integer|exists:branches,id',
        'designation' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:255',
        'salary' => 'nullable|numeric',
        'eSalaryAcc' => 'nullable|string|max:255',
        'payLeave' => 'nullable|integer',
        'npayLeave' => 'nullable|integer',
        'evmoSalarydate' => 'nullable|date',
        'status' => 'required|string',
        'joinDate' => 'nullable|date',
        'joinTime' => 'nullable|date_format:H:i',
        'author' => 'nullable|string|max:255',
    ]);

    Log::info('Validated Data:', $validatedData);

    if ($request->hasFile('photo')) {
        Log::info('Photo uploaded');
        $file = $request->file('photo');
        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/employees'), $imageName);
        $validatedData['photo'] = 'images/employees/' . $imageName;
        Log::info('Photo path:', ['photo' => $validatedData['photo']]);
    }

    $employee = Employee::create($validatedData);

    Log::info('Employee created:', ['employee' => $employee]);

    return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
}

public function update(Request $request, Employee $employee)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'gender' => 'required|string',
        'birthday' => 'nullable|date',
        'nid' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'branch_id' => 'required|integer|exists:branches,id',
        'designation' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:255',
        'salary' => 'nullable|numeric',
        'eSalaryAcc' => 'nullable|string|max:255',
        'payLeave' => 'nullable|integer',
        'npayLeave' => 'nullable|integer',
        'evmoSalarydate' => 'nullable|date',
        'status' => 'required|string',
        'joinDate' => 'nullable|date',
        'joinTime' => 'nullable|date_format:H:i',
        'author' => 'nullable|string|max:255',
        'photo' => 'nullable|image|max:2048', // Add validation rule for photo
    ]);

    // Update employee details
    $employee->fill([
        'name' => $request->input('name'),
        'gender' => $request->input('gender'),
        'birthday' => $request->input('birthday'),
        'nid' => $request->input('nid'),
        'address' => $request->input('address'),
        'branch_id' => $request->input('branch_id'),
        'designation' => $request->input('designation'),
        'phone' => $request->input('phone'),
        'salary' => $request->input('salary'),
        'eSalaryAcc' => $request->input('eSalaryAcc'),
        'payLeave' => $request->input('payLeave'),
        'npayLeave' => $request->input('npayLeave'),
        'evmoSalarydate' => $request->input('evmoSalarydate'),
        'status' => $request->input('status'),
        'joinDate' => $request->input('joinDate'),
        'joinTime' => $request->input('joinTime'),
        'author' => $request->input('author'),
    ]);

    // Handle photo update if a new photo is uploaded
    if ($request->hasFile('photo')) {
        // Delete old photo if exists
        if ($employee->photo) {
            $oldPhotoPath = public_path($employee->photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }

        // Upload new photo
        $file = $request->file('photo');
        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/employees'), $imageName);
        $employee->photo = 'images/employees/' . $imageName;
    }

    $employee->save();

    return redirect()->back()->with('success', 'Employee updated successfully.');
}


    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')
                        ->with('success', 'Employee deleted successfully.');
    }
}
