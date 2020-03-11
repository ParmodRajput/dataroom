@extends('Admin.layouts.admin')
@section('content')
<form id="HomePage" method="post" action="{{ route('postedithomepage') }}">
  @csrf
  <input type="hidden" name="name" value="home">
  <div class="row">
    <div class="col-sm-2">
      <label for="file" style="font-weight: 700;">Banner Content</label>
    </div>
    <div class="col-sm-10">
      <textarea name="section[bannercontent]" class="editor">
          {{ $sections['bannercontent'] }}
      </textarea>     
    </div>
  </div>
  <div class="row">
    <div class="col-sm-2">
      <label for="file" style="font-weight: 700;">Trusted By</label>
    </div>
    <div class="col-sm-10">
      <textarea name="section[trustedby]" class="editor">
           {{ $sections['trustedby'] }}
      </textarea>     
    </div>
  </div>
  <div class="row">
    <div class="col-sm-2">
      <label for="file" style="font-weight: 700;">Our Focus</label>
    </div>
    <div class="col-sm-10">
      <textarea name="section[focus]" class="editor">
          {{ $sections['focus'] }}
      </textarea>     
    </div>
  </div>
  <div class="row">
    <div class="col-sm-2">
      <label for="file" style="font-weight: 700;">Security and
Reliability</label>
    </div>
    <div class="col-sm-10">
      <textarea name="section[SandR]" class="editor">
          {{ $sections['SandR'] }}
      </textarea>     
    </div>
  </div>
    <div class="row">
      <div class="col-sm-2">
        <label for="file" style="font-weight: 700;">Ideal Platform</label>
      </div>
      <div class="col-sm-10">
        <textarea name="section[idealplatform]" class="editor">
           {{ $sections['idealplatform'] }}
        </textarea>     
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2">
        <label for="file" style="font-weight: 700;">Customer Reviews</label>
      </div>
      <div class="col-sm-10">
        <textarea name="section[customerreviews]" class="editor">
            {{ $sections['customerreviews'] }}
        </textarea>     
      </div>
    </div>
    <div class="form-group">
      <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>
    </div>
</form>
@endsection