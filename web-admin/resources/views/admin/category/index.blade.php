@extends('layouts.admin')

@section('main-content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">Category</h4>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    <table class="table table-bordered table-stripped">
                        <thead>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th>Parent</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{$category->nama}}</td>
                                <td>{{$category->satuan}}</td>
                                <td>{{$category->parents ? $category->parents->nama : ''}}</td>
                                <td>
                                    <form action="{{ route('category.destroy',$category->id) }}" method="POST">
                                        <a href="{{ route('category.edit',$category->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">No record found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$categories->links()}}
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('category.create') }}" class="btn btn-primary">Add News</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection