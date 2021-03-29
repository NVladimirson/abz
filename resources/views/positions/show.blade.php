@extends('layouts.main')

@section('page_header')

@php 
use Illuminate\Support\Str; 
@endphp


<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Show Position</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{  route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Show Position</li>
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
                <div class="form-group">
                    <strong>Position:</strong>
                    <div class="text-center">{{$position->position}}</div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Priority:</strong>
                    <div class="text-center">{{$position->priority}}</div>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Created at :</strong>
                    <div class="text-center">{{$position->created_at}}</div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Updated at :</strong>
                    <div class="text-center">{{$position->updated_at}}</div>
                </div>
            </div>

        </div>

            <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <a class="btn btn-danger" href="{{ route('positions.index') }}" title="Go back"> Back </a>
            </div>
            </div>

        </div>

    </div>
</div>

@endsection

@section('content')

@endsection