@extends('adminlte::page')

@section('content')
<div class="row">
<div class="col-lg-12 margin-tb">
<div class="pull-left">
<h2>Router Details</h2>
</div>
<div class="pull-right">
<a class="btn btn-success" href="{{ route('routers.create') }}"> Create New Router</a>
</div>
</div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
<p>{{ $message }}</p>
</div>
@endif
<table class="table table-bordered">
<tr>
<th>Sap Id</th>
<th>Host Name</th>
<th>Loop Back</th>
<th>Mac Address</th>
<th width="280px">Action</th>
</tr>
@foreach ($routers as $router)
<tr>
<td>{{ $router->sap_id }}</td>
<td>{{ $router->host_name }}</td>
<td>{{ $router->loop_back }}</td>
<td>{{ $router->mac_address }}</td>
<td>
<form action="{{ route('routers.destroy',$router->id) }}" method="POST">
<a class="btn btn-primary" href="{{ route('routers.edit',$router->id) }}">Edit</a>
@csrf
@method('DELETE')
<button type="submit" class="btn btn-danger">Delete</button>
</form>
</td>
</tr>
@endforeach
</table>
@endsection