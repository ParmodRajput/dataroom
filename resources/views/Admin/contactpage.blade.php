@extends('Admin.layouts.admin')
@section('content')
<form id="HomePage" method="post" action="{{ route('postcontactpage') }}">
  @csrf
  <input type="hidden" name="name" value="contact">
  <div class="row">
    <div class="col-sm-2">
      <label for="file" style="font-weight: 700;">Banner Content</label>
    </div>
    <div class="col-sm-10">
      <textarea name="section[bannercontent]" class="editor">
          This is my textarea to be replaced with CKEditor.
      </textarea>     
    </div>
  </div>
  <div class="row">
    <div class="col-sm-2">
      <label for="file" style="font-weight: 700;">Contact Us</label>
    </div>
    <div class="col-sm-10">
      <textarea name="section[contactus]" class="editor">
          This is my textarea to be replaced with CKEditor.
      </textarea>     
    </div>
  </div>
  <div class="row">
    <div class="col-sm-2">
      <label for="file" style="font-weight: 700;">Contact Address</label>
    </div>
    <div class="col-sm-10">
      <textarea name="section[contactaddress]" class="editor">
          This is my textarea to be replaced with CKEditor.
      </textarea>     
    </div>
  </div>
  <div class="form-group">
    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
  </div>
</form>
@endsection