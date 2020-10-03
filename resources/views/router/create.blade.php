@extends('adminlte::page')

@section('content')
<div class="row">
<div class="col-lg-12 margin-tb">
<div class="pull-left">
<h2>Add New Routers</h2>
</div>
<div class="pull-right">
<a class="btn btn-primary" href="{{ route('routers.index') }}"> Back</a>
</div>
</div>
</div>
@if ($errors->any())
<div class="alert alert-danger">
<strong>Whoops!</strong> There were some problems with your input.<br><br>
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<form action="{{ route('routers.store') }}" method="POST">
@csrf
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Sap Id:</strong>
<input type="text" name="sap_id" class="form-control" placeholder="sap id" value="{{ Request::old('sap_id') }}">
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Host Name:</strong>
<input type="text" class="form-control" name="host_name" placeholder="host name" value="{{ Request::old('host_name') }}">
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Loop Back:</strong>
<input type="text" class="form-control" name="loop_back" placeholder="loop back" value="{{ Request::old('loop_back') }}">
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Mac Address:</strong>
<input type="text" class="form-control" name="mac_address" placeholder="mac address" value="{{ Request::old('mac_address') }}">
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 text-center">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>
</form>
@endsection