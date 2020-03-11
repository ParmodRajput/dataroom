@extends('Admin.layouts.admin')
@section('content')
<form id="HomePage" method="post" action="{{ route('postaddPage') }}">
  @csrf
  <div class="form-group">
    <label class="control-label">Name</label>
    <input class="form-control" type="text" placeholder="Page Name" name="name" value="">
  </div>
    <div class="form-group">
      <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
    </div>
</form>
@endsection