@extends('layouts.main')

@section('page_header')

@php 
use Illuminate\Support\Str; 
@endphp


<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create Employee</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{  route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Create Employee</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <div class="card-body">
      <div class="row">
      <div class="col-sm-12">
      @if ($message = Session::get('success'))
            <div class="alert alert-success">
               <p>{{ $message }}</p>
            </div>
            @endif
            @if ($errors->any())
        <div class="alert alert-danger">
            <!-- <strong>Whoops!</strong> There were some problems with your input.<br><br> -->
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
      </div>
      </div>
    <form id="create-form" action="{{ route('employees.store') }}" method="POST"  enctype="multipart/form-data">

        @csrf

        <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12">
             <div class="form-group">

            </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Change Photo:</strong>
                    <input id="photo" type="file" name="logo" class="form-control">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>First Name:</strong>
                    <input type="text" name="first_name" class="form-control" required placeholder="First Name" value="">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Last Name:</strong>
                    <input type="text" name="last_name" class="form-control" required placeholder="Last Name" value="">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="text" name="email" class="form-control" required placeholder="Email" value="">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Phone:</strong>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">+380</span>
                      </div>
                      <input type="text" name="phone" class="form-control" required placeholder="phone" value="">
                      <!-- <div class="input-group-append">
                      <span class="input-group-text">.00</span>
                      </div> -->
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Position:</strong>
                    <select name="position" class="form-control" id="positions">
                      @php use Illuminate\Support\Arr; @endphp
                      @forelse($positions as $key => $position)
                        <option value = "{{ $position->id }}"   @if($positions->last()->id == $position->id) selected @endif >{{ $position->position }}</option>
                        @empty
                        <option value="0"> - </option>
                      @endforelse
                    </select>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Salary:</strong>

                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                      </div>
                      <input type="text" name="salary" class="form-control" required placeholder="Salary" value="">
                      <div class="input-group-append">
                      <span class="input-group-text">.00</span>
                    </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Head:</strong>

                    <select name="higher_up" class="form-control" id="higher_ups">

                      @forelse($higher_ups as $higher_up)
                        <option value = "{{ $higher_up->id }}" @if($higher_ups->first()->id == $higher_up->id) selected @endif>{{ $higher_up->first_name }} {{ $higher_up->last_name }}</option>
                      @endforeach
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Date Of Employment:</strong>
                    <input id="datetimepicker" name="date_of_employment" class="date_picker form-control type="text" >
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6 text-center">
              <!-- <button class="btn btn-danger ">Cancel</button> -->
              <a class="btn btn-danger" href="{{ route('employees.index') }}" title="Go back"> Back </a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 text-center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>

    </form>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" rel="stylesheet" crossorigin="anonymous" />

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>


// jQuery('#datetimepicker').datetimepicker({
//   format:'Y-m-d h:m:s',
// });
jQuery('#datetimepicker').datetimepicker(
  {
    value: new Date(),
    format:'Y-m-d h:m:s'
  }
);

jQuery(function($) {


  // $('#higher_ups').select2('data', {id: 100, text: 'Lorem Ipsum'});

  $('#higher_ups').select2({
					ajax: {
						url: function () {
							return "{{ route('get-higherups') }}"
						},
						dataType: 'json',
						data: function (params) {
							return {
								search: params.term,
                position_id: $('#positions').val(),
							};
						},
						processResults: function (data) {
              console.log(data);
							return {
								results: data
							};
						},
						cache: true
					},
});

$(document).on("change", "#photo", function(e){

if(this.files[0].size > 5120000){
   alert("File is too big!");
   this.value = "";
};

fileInput = this.files[0];
// file = fileInput.files && fileInput.files[0];
if (fileInput) {
   var img = new Image();
   img.src = window.URL.createObjectURL(fileInput);

    img.onload = function() {
        var width = img.naturalWidth, height = img.naturalHeight;
        if( width < 300 || height < 300 ) {
          $('#photo').val('');
          alert("File resolution is less than 300!");
        }
    }; 
}
}); 
 


  $("#create-form").validate({
             rules:{
                logo:{
                  required: true,
                },
                first_name:{
                  required: true,
                  minlength: 2,
                  maxlength: 255,
                },
                last_name:{
                  required: true,
                  minlength: 2,
                  maxlength: 255,
                },
                email:{
                  required: true,
                   email : true
                },
                phone:{
                  required: true,
                  digits: true,
                  minlength: 9,
                  maxlength: 9,

                },
                // position:{
                //   required: true,
                // },
                salary:{
                  required: true,
                  number : true,
                  max : 500000,
                  min : 0,
                },
                // higher_up:{
                //   required: true,
                // },
                date_of_employment:{
                  required: true,
                  date: true
                },

             },
             messages:{
                first_name:{
                 required: "Please enter first name",
                 minlength: "Name should be at least 2 characters long",
                 maxlength: "Name should be 255 characters maximum",
                },
                last_name:{
                 required: "Please enter last name",
                 minlength: "Last name should be at least 2 characters long",
                 maxlength: "Last name should be 255 characters maximum",
                },
             }
          });

          $('#higher_ups').on('select2:select', function (e) { 
            select_val = $(e.currentTarget).val();
          });

            


        } );


</script>
@endsection

@section('content')

@endsection