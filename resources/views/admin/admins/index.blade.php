@extends('admin')

@section('title', 'Administrators')
@section('subtitle', 'List admins')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li><a href="{{ url('/admin/') }}"><i class="fa fa-group"></i> Home</a></li>
        <li class="active">Administrators</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Administrators<span class="margin"></span><span class="margin"></span><a href="{{ url('admin/admins/add') }}" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i> Add administrator</a></h3>
                        <form action="{{ url('admin/admins') }}" method="get" class="sidebar-form pull-right col-sm-3 no-padding">
                            <div class="input-group">
                                <input type="text" name="s" class="form-control" placeholder="Search admins" value="{{ Input::get('s') }}"/>
                            <span class="input-group-btn">
                                <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                            </div>
                        </form>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <?php echo $admins->render(); ?>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full name</th>
                                <th>Email</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td><a href="{{ url('admin/admins/edit/' . $user->id) }}">{{ $user->name }}</a></td>
                                <td><a href="{{ url('admin/admins/edit/' . $user->id) }}">{{ $user->email }}</a></td>
                                <td>
                                    <a href="{{ url('admin/admins/edit/' . $user->id) }}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
                                    @if ($user->id != Auth::admin()->user()->id)
                                        <a href="{{ url('admin/admins/delete/' . $user->id) }}" class="btn btn-xs btn-danger btn-delete" data-item-type="administrator"><i class="fa fa-remove"></i> Delete</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Full name</th>
                                <th>Email</th>
                                <th>Options</th>
                            </tr>
                            </tfoot>
                        </table>
                        <?php echo $admins->render(); ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

    </section>
@endsection