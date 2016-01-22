@extends('admin')

@section('title', 'Cards')
@section('subtitle', 'List cards')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li><a href="{{ url('/admin/') }}"><i class="fa fa-group"></i> Home</a></li>
        <li class="active">Cards</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Cards<span class="margin"></span><span class="margin"></span><a href="{{ url('admin/cards/add') }}" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i> Add card</a></h3>
                        <form action="{{ url('admin/cards') }}" method="get" class="sidebar-form pull-right col-sm-3 no-padding">
                            <div class="input-group">
                                <input type="text" name="s" class="form-control" placeholder="Search cards" value="{{ Input::get('s') }}"/>
                            <span class="input-group-btn">
                                <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                            </div>
                        </form>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <?php echo $cards->render(); ?>
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
                            @foreach($cards as $card)
                            <tr>
                                <td>{{ $card->id }}</td>
                                <td>{{ $card->title }}</td>
                                <td><?php for ($i=0;$i<$card->difficulty;$i++) { echo '<i class="fa fa-star"></i>';}?></td>
                                <td><img src="{{ iconPath($card->icon) }}" alt="" width="64" height="64"/></td>
                                <td><img src="{{ iconPath($card->icon_grey) }}" alt="" width="64" height="64"/></td>
                                <td>
                                    <a href="{{ url('admin/cards/edit/' . $card->id) }}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ url('admin/cards/delete/' . $card->id) }}" class="btn btn-xs btn-danger btn-delete" data-item-type="card"><i class="fa fa-remove"></i> Delete</a>
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
                        <?php echo $cards->render(); ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

    </section>
@endsection