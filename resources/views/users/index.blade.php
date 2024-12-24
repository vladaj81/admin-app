@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Users Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Create New User</a>
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
        <th>User Id</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th>Permissions</td>
        <th>Action</th>
   </tr>
   @foreach ($data as $key => $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $roles)
                    <label class="badge bg-success">{{ $roles }}</label>
                @endforeach
            @endif
        </td>
        <td>
            @if(!empty($user->getPermissionNames()))
                @foreach($user->getPermissionNames() as $permission)
                    <label class="badge bg-success">{{ $permission }}</label>
                @endforeach
            @endif
        </td>
        <td>
            <a class="btn btn-primary btn-sm" href="{{ route('users.edit', $user->id) }}">Edit</a>
            <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
 @endforeach
</table>

{!! $data->links('pagination::bootstrap-5') !!}

@stop
