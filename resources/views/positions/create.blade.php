@extends('layouts.main')

@section('page_header')

@php 
use Illuminate\Support\Str; 
@endphp


<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create Position</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{  route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Create Position</li>
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
    <form id="create-form" action="{{ route('positions.store') }}" method="POST">

        @csrf

        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Change Position Name:</strong>
                    <input type="text" name="position" class="form-control" required placeholder="Position" value="">
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Available Priorities:</strong>
                    <select name="priority" class="form-control" id="positions">
                      <option value = {{$lowest_priority}} selected> Next Lowest Priority: {{$lowest_priority}} </option>
                      @forelse($available_priorities as $available_priority)
                        <option value = "{{ $available_priority }}">Missing Priority: {{ $available_priority }}</option>
                        @empty
                      @endforelse
                    </select>
                </div>
            </div>


            <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 text-center">
              <!-- <button class="btn btn-danger ">Cancel</button> -->
              <a class="btn btn-danger" href="{{ route('positions.index') }}" title="Go back"> Back </a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 text-center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
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


jQuery(function($) {

  $("#create-form").validate({
             rules:{
                position:{
                  required: true,
                  minlength: 2,
                  maxlength: 255,
                },
                priority:{
                  required: true,
                }
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

        } );

</script>
@endsection

@section('content')

@endsection