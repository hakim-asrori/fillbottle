@extends('layouts.admin')

@section('main-content')
@php
$formTitle = !empty($user)?'Update':'New'
@endphp
<div class="content">
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">{{$formTitle}} User</h4>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    @if(!empty($user))
                    {!! Form::model($user, ['url' => ['admin/user',$user->id],'method' =>'PUT'])!!}
                    {!! Form::hidden('id')!!}
                    @else
                    {!! Form::open(['url' => 'admin/user','method' => 'POST'])!!}
                    @endif
                    <h6 class="heading-small text-muted mb-4">Partner information</h6>

                    <div class="pl-lg-4">
                        <div class="form-group">
                            {!! Form::label('name','Nama Depan')!!}
                            {!! Form::text('name',null,['class' =>'form-control','placeholder'=>'Nama Depan'])!!}
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('last_name','Nama Belakang')!!}
                            {!! Form::text('last_name',null,['class' =>'form-control','placeholder'=>'Nama Belakang'])!!}
                            @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('email','Email')!!}
                            {!! Form::email('email',null,['class' =>'form-control','placeholder'=>'Email'])!!}
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('password','Password')!!}
                            {{ Form::password('password', array('id' => 'password', "class" => "form-control")) }}
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('level', 'Level') !!}
                            {!! Form::select('level', $levels , !empty($user) ? $user->level : null, ['class' => 'form-control user-level', 'placeholder' => '-- Set Level --']) !!}
                            @error('level')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="show-level">
                            <div class="form-group">
                                {!! Form::label('branch_id', 'Branch') !!}
                                {!! General::selectMultiLevel2('branch_id', $branches, [
                                'class' => 'form-control',
                                'selected' => empty($branchID) ? "" : $branchID,
                                'placeholder' => '-- Choose Branch --']) !!}
                                @if(empty($branches))
                                <span class="text-danger">Data Kosong, Admin Belum Memasukkan Data</span>
                                @endif
                                @error('branch_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-footer pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Save</button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary btn-default">Back</a>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection