@extends('Admin.layouts.admin')
@section('content')
<form id="HomePage" method="post" action="{{ route('posthomepage') }}">
  @csrf
  <input type="hidden" name="name" value="home">
  <!-- <div class="row">
    <div class="col-sm-12">
      <div class="row">
         <div class="col-sm-2">
           <label for="file" style="font-weight: 700;"> Upload Banner Image</label>
         </div>
        <div class="col-sm-2 imgUp">
           <div class="imagePreview"></div>
           <label class="btn btn-primary">
           Upload<input type="file" class="uploadFile img" value="Upload Photo" name=uploadFile[] style="width: 0px;height: 0px;overflow: hidden;" data-max=1>
           </label>
        </div>
        <i class="fa fa-plus imgAdd"></i>
      </div>
    </div>
  </div> -->
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
      <label for="file" style="font-weight: 700;">Trusted By</label>
    </div>
    <div class="col-sm-10">
      <textarea name="section[trustedby]" class="editor">
          This is my textarea to be replaced with CKEditor.
      </textarea>     
    </div>
  </div>
  <!-- <div class="row">
    <div class="col-sm-12">
      <div class="row">
         <div class="col-sm-2">
           <label for="file" style="font-weight: 700;">Trusted By Image</label>
         </div>
        <div class="col-sm-2 imgUp">
           <div class="imagePreview"></div>
           <label class="btn btn-primary">
           Upload<input type="file" class="uploadFile img" value="Upload Photo" name=uploadFile[] style="width: 0px;height: 0px;overflow: hidden;" data-max=6>
           </label>
        </div>
        <i class="fa fa-plus imgAdd"></i>
      </div>
    </div>
  </div> -->
  <div class="row">
    <div class="col-sm-2">
      <label for="file" style="font-weight: 700;">Our Focus</label>
    </div>
    <div class="col-sm-10">
      <textarea name="section[focus]" class="editor">
          This is my textarea to be replaced with CKEditor.
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
          This is my textarea to be replaced with CKEditor.
      </textarea>     
    </div>
  </div>
    <div class="row">
      <div class="col-sm-2">
        <label for="file" style="font-weight: 700;">Ideal Platform</label>
      </div>
      <div class="col-sm-10">
        <textarea name="section[idealplatform]" class="editor">
            This is my textarea to be replaced with CKEditor.
        </textarea>     
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2">
        <label for="file" style="font-weight: 700;">Customer Reviews</label>
      </div>
      <div class="col-sm-10">
        <textarea name="section[customerreviews]" class="editor">
            This is my textarea to be replaced with CKEditor.
        </textarea>     
      </div>
    </div>
    <div class="form-group">
      <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>
    </div>
</form>
@endsection