@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Permission Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success btn-sm mb-2" href="{{ route('permissions.create') }}"><i class="fa fa-plus"></i> Create New Permission</a>
        </div>
    </div>
</div>

@session('success')
    <div class="alert alert-success" role="alert"> 
        {{ $value }}
    </div>
@endsession

<table class="table table-bordered">
  <tr>
        <th>Permission Id</th>
        <th>Permission Name</th>
        <th>Action</th>
  </tr>
    @foreach ($permissions as $key => $permission)
    <tr>
        <td>{{ $permission->id }}</td>
        <td>{{ $permission->name }}</td>
        <td>
            <a class="btn btn-primary btn-sm" href="{{ route('permissions.edit', $permission->id) }}">Edit</a>

            <form method="POST" action="{{ route('permissions.destroy', $permission->id) }}" style="display:inline">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{!! $permissions->links('pagination::bootstrap-5') !!}

@endsection
