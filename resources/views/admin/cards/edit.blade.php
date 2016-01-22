@extends('admin')

@section('title', 'Cards')
@section('subtitle', 'Edit card')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li><a href="{{ url('/admin/') }}"><i class="fa fa-group"></i> Home</a></li>
        <li><a href="{{ url('/admin/cards') }}">Cards</a></li>
        <li class="active">Edit</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary">

                    <div class="box-body">
                        <form role="form" enctype="multipart/form-data" action="{{ url('admin/cards/save/' . $card->id) }}" method="post">
                            @include('admin/cards/_form')
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

    </section>
@endsection