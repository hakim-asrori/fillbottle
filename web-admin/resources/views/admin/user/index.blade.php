@extends('layouts.admin')

@section('main-content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">User</h4>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    <table class="table table-bordered table-stripped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->level_name }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$users->links()}}
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('user.create') }}" class="btn btn-primary">Add News</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection