@extends('admin/layouts.app')

@section('content')
<!-- index.blade.php -->
<div class="row">
    <div align="right"><a class="btn btn-sm btn-info" href="{{ route('AdminPlans') }}">Plans</a></div>
<div class="container">
    <h5>Edit your subscription plans</h5>
    <div class="card col-6">
 <form method="POST" action="{{route('updatePlans')}}">
 @csrf
 <input type="hidden" id="plan_id" name="plan_id" value="{{ $plan->id }}" required>
<div class="form-group">
    <label for="name" class="mb-1">Plan Name</label>
    <input type="text" id="name" name="name" value="{{ $plan->name }}" placeholder="Enter Plan name" class="form-control" required>
</div>
<div class="form-group">
    <label for="duration" class="mb-1">Duration Days</label>
    <input type="text" id="duration" name="duration" value="{{ $plan->duration }}" placeholder="Enter duration days" class="form-control" required>
</div>
<div class="form-group">
    <label for="amount" class="mb-1">Package amount</label>
    <input type="text" id="amount" name="amount" value="{{ $plan->amount }}" class="form-control" required>
</div>
<div class="form-group">
    <label for="ads_times" class="mb-1">Ads interval</label>
    <input type="text" id="ads_times" name="ads_times" value="{{ $plan->ads_times }}" class="form-control"  required>
</div>
<div class="form-group">
      <label for="details">Write Packgaes details</label>
      <textarea class="form-control" id="details" name="details" placeholder="Enter Plans details" rows="3" maxlength="500" >{{ $plan->details }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
 </form>
 </div>
</div>
</div>


@endsection


@section('scripts')


@endsection