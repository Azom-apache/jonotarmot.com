@extends('admin/layouts.app')

@section('content')
<!-- index.blade.php -->
<div class="row">
    <!-- <div align="right"><a class="btn btn-sm btn-info" href="{{ route('plans') }}">Plans</a></div> -->
<div class="container">
    <h5>Add a banner Image</h5>
    <div class="card col-6">
 <form method="POST" action="{{ route('add.banner') }}" enctype="multipart/form-data">
 @csrf
<div class="form-group">
    <label for="banner_name" class="mb-1">Banner name</label>
    <input type="text" id="banner_name" name="banner_name" placeholder="Enter banner name" class="form-control" required>
</div>
<div class="form-group">
    <label for="image" class="mb-1">Image</label>
    <input type="file" id="image" name="image" placeholder="Enter duration days" class="form-control" required>
</div>
        <button type="submit" class="btn btn-primary">Submit</button>
 </form>
 </div>
</div>
</div>


@endsection


@section('scripts')


@endsection