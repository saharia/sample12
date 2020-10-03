@extends('adminlte::page')

@section('content')
<div class="row">
<div class="col-lg-12 margin-tb">
<div class="pull-left">
<h2>Edit Blogs</h2>
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
<form action="{{ route('routers.update',$router->id) }}" method="POST">
@csrf
@method('PUT')
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Sap Id:</strong>
<input type="text" name="sap_id" value="{{ Request::old('sap_id') ? Request::old('sap_id') : $router->sap_id }}" class="form-control" placeholder="Sap Id">
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Host Name:</strong>
<input type="text" name="host_name" value="{{ Request::old('host_name') ? Request::old('host_name') : $router->host_name }}" class="form-control" placeholder="Host Name">
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Loop Back:</strong>
<input type="text" name="loop_back" value="{{ Request::old('loop_back') ? Request::old('loop_back') : $router->loop_back }}" class="form-control" placeholder="Loop Back">
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Mac Address:</strong>
<input type="text" name="mac_address" value="{{ Request::old('mac_address') ? Request::old('mac_address') : $router->mac_address }}" class="form-control" placeholder="Mac Address">
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 text-center">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>
</form>
@endsection