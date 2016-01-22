@extends('admin')

@section('title', 'Gear')
@section('subtitle', 'Edit gear')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li><a href="{{ url('/admin/') }}"><i class="fa fa-group"></i> Home</a></li>
        <li><a href="{{ url('/admin/awards') }}">Gears</a></li>
        <li class="active">Add</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary">
                    <div class="box-body">
                        <form role="form" enctype="multipart/form-data" action="{{ url('admin/awards/save/') }}" method="post">
                            @include('admin/awards/_form')
                        </form>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>

    </section>
@endsection
