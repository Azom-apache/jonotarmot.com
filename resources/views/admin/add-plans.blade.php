@extends('admin/layouts.app')

@section('content')
<!-- index.blade.php -->
<div class="row">
    <div align="right"><a class="btn btn-sm btn-info" href="{{ route('AdminPlans') }}">Plans</a></div>
<div class="container">
    <h5>Add your subscription plans</h5>
    <div class="card col-6">
 <form method="POST" action="{{ route('addSub') }}">
 @csrf
<div class="form-group">
    <label for="name" class="mb-1">Plan Name</label>
    <input type="text" id="name" name="name" placeholder="Enter Plan name" class="form-control" required>
</div>
<div class="form-group">
    <label for="duration" class="mb-1">Duration</label>
    <select name="duration" class="form-control" id="duration">
        <option value="">Select type</option>
        <option value="Monthly">Monthly</option>
        <option value="Yearly">Yearly</option>

    </select>
</div>
<div class="form-group">
    <label for="amount" class="mb-1">Package amount</label>
    <input type="text" id="amount" name="amount" class="form-control" required>
</div>
<div class="form-group">
    <label for="ads_times" class="mb-1">Ads interval</label>
    <input type="text" id="ads_times" name="ads_times" class="form-control"  required>
</div>
<div class="form-group">
      <label for="details">Write Packgaes details</label>
      <textarea class="form-control" id="details" name="details" placeholder="Enter Plans details" rows="3" maxlength="500"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
 </form>
 </div>
</div>
</div>


@endsection


@section('scripts')


@endsection