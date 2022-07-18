@extends('layouts.admin')

@section('main-content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">Kurir</h4>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    <table class="table table-bordered table-stripped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kurirs as $kurir)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $kurir->full_name }}</td>
                                <td>{{ $kurir->email }}</td>
                                <td>{{ $kurir->alamat_lengkap }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('kurir.edit', $kurir->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
                                        <form action="{{ route('kurir.destroy', $kurir->user_id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">No record found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$kurirs->links()}}
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('kurir.create') }}" class="btn btn-primary">Add News</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection