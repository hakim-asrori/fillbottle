@extends('layouts.admin')

@section('main-content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">Product</h4>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    <table class="table table-bordered table-stripped">
                        <thead>
                            <th>No</th>
                            <th>Image</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td><img src="{{ asset('storage/'.$product->foto) }}" style="width:150px; height: 100px; border-radius: 0.35rem;" /></td>
                                <td>{{ $product->kode }}</td>
                                <td>{{ $product->nama }}</td>
                                <td>
                                    <form action="{{ route('product.destroy',$product->id) }}" method="POST">
                                        <a href="{{ route('product.edit',$product->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">No records found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('product.create') }}" class="btn btn-primary">Add News</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection