@extends('layouts.admin')

@section('main-content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">Partner</h4>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    <table class="table table-bordered table-stripped">
                        <thead>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @forelse($partners as $partner)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{$partner->nama}}</td>
                                <td>Telp : {{$partner->telp}}</br>Email : {{$partner->email}}</td>
                                <td>{{$partner->alamat_lengkap}}</td>
                                <td>
                                    <form action="{{ route('partner.destroy',$partner->id) }}" method="POST">
                                        <a href="{{ route('partner.edit',$partner->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
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
                    {{$partners->links()}}
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('partner.create') }}" class="btn btn-primary">Add News</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection