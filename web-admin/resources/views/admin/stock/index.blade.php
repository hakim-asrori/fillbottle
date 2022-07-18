@extends('layouts.admin')

@php
$branch_id = $bid;
$branch_name = $bname;
@endphp

@section('main-content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">Stock Product {{$branch_name}}</h4>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    <table class="table table-bordered table-stripped">
                        <thead>
                            <th>No</th>
                            <th>Product</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @forelse($stocks as $stock)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{$stock->product->nama}}</td>
                                <td>{{$stock->stok}}</td>
                                <td>
                                    <form action="{{ route('stock.destroy',$stock->id) }}" method="POST">
                                        <a href="{{ route('stock.edit',$stock->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
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
                    {{$stocks->links()}}
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('stock.create',array('id' => $branch_id)) }}" class="btn btn-primary">Add News</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection