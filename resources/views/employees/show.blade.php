@extends('layouts.main')

@section('page_header')

@php 
use Illuminate\Support\Str; 
@endphp


<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Show Employee</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{  route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Show Employee</li>
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

        <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12">
             <div class="form-group align-middle">
             <strong>Image:</strong>
             <div class="text-center"><img src="{{asset($employee->photo)}}" style="max-height:100px;max-width:100px"></div>
            </div>
            </div>

        </div>

            <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Change Photo:</strong>
                    <input type="file" name="logo" class="form-control">
                </div>
            </div> -->

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>First Name:</strong>
                    <div class="text-center">{{$employee->first_name}}</div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Last Name:</strong>
                    <!-- <input type="text" name="last_name" class="form-control" required placeholder="Наименование" value="{{$employee->last_name}}"> -->
                    <div class="text-center">{{$employee->last_name}}</div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <!-- <input type="text" name="email" class="form-control" required placeholder="Наименование" value="{{$employee->email}}"> -->
                    <div class="text-center">{{$employee->email}}</div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Phone:</strong>
                    <div class="text-center">{{$employee->phone}}</div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Position:</strong>
                    @if($employee->position != null)
                    <div class="text-center">{{$employee->position->position}}</div>
                    @else
                    <div class="text-center">-</div>
                    @endif

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Salary:</strong>
                    <div class="text-center">{{$employee->salary}}</div>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Head:</strong>
                    <!-- <select name="higher_up" class="form-control" id="higher_ups" style="width:100%; height:50px !important "> -->
                      @if($employee->higher_up != null)
                      <div class="text-center">{{$employee->higher_up->first_name}} {{$employee->higher_up->last_name}}</div>
                      @else
                      <div class="text-center">-</div>
                      @endif
                    
                    </select>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Date Of Employment:</strong>
                    <!-- <input type="text" name="date_of_employment" class="form-control" required placeholder="Наименование" value="{{$employee->recruitment_date}}"> -->
                    <!-- <input value="" name="date_from" class="date_picker form-control" id="datetimepicker" required > -->
                    <!-- <input id="datetimepicker" name="date_of_employment" class="date_picker form-control" type="text" > -->
                    <div class="text-center">{{$employee->recruitment_date}}</div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Created at :</strong>
                    <!-- <input type="text" name="date_of_employment" class="form-control" required placeholder="Наименование" value="{{$employee->recruitment_date}}"> -->
                    <!-- <input value="" name="date_from" class="date_picker form-control" id="datetimepicker" required > -->
                    <!-- <input id="datetimepicker" name="date_of_employment" class="date_picker form-control" type="text" > -->
                    <div class="text-center">{{$employee->created_at}}</div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Admin created id :</strong>
                    <!-- <input type="text" name="date_of_employment" class="form-control" required placeholder="Наименование" value="{{$employee->recruitment_date}}"> -->
                    <!-- <input value="" name="date_from" class="date_picker form-control" id="datetimepicker" required > -->
                    <!-- <input id="datetimepicker" name="date_of_employment" class="date_picker form-control" type="text" > -->
                    <div class="text-center">{{$employee->admin_created_id}}</div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Updated at :</strong>
                    <!-- <input type="text" name="date_of_employment" class="form-control" required placeholder="Наименование" value="{{$employee->recruitment_date}}"> -->
                    <!-- <input value="" name="date_from" class="date_picker form-control" id="datetimepicker" required > -->
                    <!-- <input id="datetimepicker" name="date_of_employment" class="date_picker form-control" type="text" > -->
                    <div class="text-center">{{$employee->updated_at}}</div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Admin updated id :</strong>
                    <!-- <input type="text" name="date_of_employment" class="form-control" required placeholder="Наименование" value="{{$employee->recruitment_date}}"> -->
                    <!-- <input value="" name="date_from" class="date_picker form-control" id="datetimepicker" required > -->
                    <!-- <input id="datetimepicker" name="date_of_employment" class="date_picker form-control" type="text" > -->
                    <div class="text-center">{{$employee->admin_updated_id}}</div>
                </div>
            </div>
            
            <!-- <div class="col-xs-12 col-sm-12 col-md-12">
              <b>Created at :</b> {{$employee->created_at}}
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <b>Admin created id :</b> {{$employee->admin_created_id}}
              </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
              <b>Updated at :</b> {{$employee->updated_at}}
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
              <b>Admin updated id :</b> {{$employee->admin_updated_id}}
            </div> -->

            </div>

            <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <!-- <button class="btn btn-danger ">Cancel</button> -->
              <a class="btn btn-danger" href="{{ route('employees.index') }}" title="Go back"> Back </a>
            </div>
            <!-- <div class="col-xs-6 col-sm-6 col-md-6 text-center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div> -->
            </div>

        </div>

    </div>
</div>

@endsection

@section('content')

@endsection