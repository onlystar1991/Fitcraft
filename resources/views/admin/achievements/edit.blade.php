@extends('admin')

@section('title', 'Achievements')
@section('subtitle', 'Edit achievement')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li><a href="{{ url('/admin/') }}"><i class="fa fa-group"></i> Home</a></li>
        <li><a href="{{ url('/admin/achievements') }}">Achievements</a></li>
        <li class="active">Edit</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <form role="form" enctype="multipart/form-data" action="{{ url('admin/achievements/save/'.$achievement->id) }}" method="post">
                            @include('admin.achievements._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
