@extends('admin')

@section('title', 'Gears')
@section('subtitle', 'List Gears')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li><a href="{{ url('/admin/') }}"><i class="fa fa-group"></i> Home</a></li>
        <li class="active">Gears</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Gears<span class="margin"></span><span class="margin"></span><a href="{{ url('admin/awards/add') }}" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i> Add gear</a></h3>
                        <form action="{{ url('admin/awards') }}" method="get" class="sidebar-form pull-right col-sm-3 no-padding">
                            <div class="input-group">
                                <input type="text" name="s" class="form-control" placeholder="Search gear" value="{{ Input::get('s') }}"/>
                            <span class="input-group-btn">
                                <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                            </div>
                        </form>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <?php echo $awards->render(); ?>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Difficulty</th>
                                <th>Icon</th>
                                <th>Icon disabled</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($awards as $award)
                            <tr>
                                <td>{{ $award->id }}</td>
                                <td>{{ $award->title }}</td>
                                <td><?php for ($i=0;$i<$award->difficulty;$i++) { echo '<i class="fa fa-star"></i>';}?></td>
                                <td><img src="{{ iconPath($award->icon) }}" alt="" width="64" height="64"/></td>
                                <td><img src="{{ iconPath($award->icon_grey) }}" alt="" width="64" height="64"/></td>
                                <td>
                                    <a href="{{ url('admin/awards/edit/' . $award->id) }}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ url('admin/awards/delete/' . $award->id) }}" class="btn btn-xs btn-danger btn-delete" data-item-type="award"><i class="fa fa-remove"></i> Delete</a>
                                </td>

                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Full name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Options</th>
                            </tr>
                            </tfoot>
                        </table>
                        <?php echo $awards->render(); ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

    </section>
@endsection