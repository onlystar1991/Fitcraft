@extends('admin')

@section('title', 'Achievements')
@section('subtitle', 'List achievements')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li><a href="{{ url('/admin/') }}"><i class="fa fa-group"></i> Home</a></li>
        <li class="active">Achievements</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Achievements<span class="margin"></span><span class="margin"></span><a href="{{ url('admin/achievements/add') }}" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i> Add</a></h3>
                        <form action="{{ url('admin/achievements') }}" method="get" class="sidebar-form pull-right col-sm-3 no-padding">
                            <div class="input-group">
                                <input type="text" name="s" class="form-control" placeholder="Search achievements" value="{{ Input::get('s') }}"/>
                            <span class="input-group-btn">
                                <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                            </div>
                        </form>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        {!! $achievements->render() !!}
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Icon disabled</th>
                                <th>Difficulty</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Points</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($achievements as $achievement)
                            <tr>
                                <td>{{ $achievement->id }}</td>
                                <td>{{ $achievement->title }}</td>
                                <td><img src="{{ iconPath($achievement->icon) }}" alt="" width="64" height="64"/></td>
                                <td><img src="{{ iconPath($achievement->icon_grey) }}" alt="" width="64" height="64"/></td>
                                <td>{{ $achievement->difficulty }}</td>
                                <td>{{ $achievement->category_title }}</td>
                                <td>{{ !is_null($achievement->sub_category_title) ? $achievement->sub_category_title : '-' }}</td>
                                <td>{{ $achievement->points }}</td>
                                <td>
                                    <a href="{{ url('admin/achievements/edit/' . $achievement->id) }}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ url('admin/achievements/delete/' . $achievement->id) }}" class="btn btn-xs btn-danger btn-delete" data-item-type="achievement"><i class="fa fa-remove"></i> Delete</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Icon disabled</th>
                                <th>Difficulty</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Points</th>
                                <th></th>
                            </tfoot>
                        </table>
                        {!! $achievements->render() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

    </section>
@endsection