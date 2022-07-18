@extends('layouts.admin')

@section('main-content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">Customer</h4>
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
                            @forelse ($customers as $customer)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $customer->full_name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->alamat_lengkap }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
                                        <form action="{{ route('customer.destroy', $customer->user_id) }}" method="post">
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
                    {{$customers->links()}}
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('customer.create') }}" class="btn btn-primary">Add News</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection