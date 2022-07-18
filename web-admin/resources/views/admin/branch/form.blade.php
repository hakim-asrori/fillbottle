@extends('layouts.admin')

@section('main-content')
@php
$formTitle = !empty($branch)?'Update':'New'
@endphp
<div class="content">
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">{{$formTitle}} Branch</h4>
                </div>
                <div class="card-body">
                    @if(!empty($branch))
                    {!! Form::model($branch, ['url' => ['admin/branch',$branch->id],'method' =>'PUT'])!!}
                    {!! Form::hidden('id')!!}
                    @else
                    {!! Form::open(['url' => 'admin/branch','method' => 'POST'])!!}
                    @endif
                    <h6 class="heading-small text-muted mb-4">Branch information</h6>

                    <div class="pl-lg-4">
                        <div class="form-group">
                            {!! Form::label('nama','Nama Cabang')!!}
                            {!! Form::text('nama',null,['class' =>'form-control','placeholder'=>'Nama Cabang'])!!}
                            @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('pimpinan','Pimpinan Cabang')!!}
                            {!! Form::text('pimpinan',null,['class' =>'form-control','placeholder'=>'Pimpinan Cabang'])!!}
                            @error('pimpinan')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('alamat','Alamat') !!}
                                    {!! Form::text('alamat', null,['class' => 'form-control', 'placeholder' => 'Alamat']) !!}
                                    @error('alamat')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('kota','Kota/Kabupaten') !!}
                                    {!! Form::text('kota', null,['class' => 'form-control', 'placeholder' => 'Kota/Kabupaten']) !!}
                                    @error('kota')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('provinsi','Provinsi') !!}
                                    {!! Form::text('provinsi', null,['class' => 'form-control', 'placeholder' => 'Provinsi']) !!}
                                    @error('provinsi')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('kodepos','Kodepos') !!}
                                    {!! Form::text('kodepos', null,['class' => 'form-control', 'placeholder' => 'Kodepos']) !!}
                                    @error('kodepos')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('email','Email') !!}
                                    {!! Form::email('email', null,['class' => 'form-control', 'placeholder' => 'Email']) !!}
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('telp','Telephone') !!}
                                    {!! Form::text('telp', null,['class' => 'form-control', 'placeholder' => 'Telephone']) !!}
                                    @error('telp')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-footer pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Save</button>
                            <a href="{{ route('branch.index') }}" class="btn btn-secondary btn-default">Back</a>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection