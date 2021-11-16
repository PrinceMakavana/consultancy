<?php

use App\Greetings;
    use App\Utils;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Greetings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Greetings</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">

            {{Utils::successAndFailMessage()}}

            <div class="card-header">
                <a href="{{ route('greetings.create') }}" class="btn btn-sm btn-success">Add</a>
                <a href="{{ route('greetings.calendar') }}" class="btn btn-sm btn-primary">Calendar</a>
                <a href="{{ route('greetings.test-greeting') }}" class="btn btn-sm btn-warning">Test Greeting</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-bordered" id="greetings_table_data">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th><?= Greetings::attributes('image') ?></th>
                            <th><?= Greetings::attributes('title') ?></th>
                            <th><?= Greetings::attributes('date') ?></th>
                            <th><?= Greetings::attributes('status') ?></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</section>
@stop

@push('scripts')
<script>
    $(function() {
    var t = $('#greetings_table_data').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('greetings.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: '_image', name: 'image' ,
                render: function( data, type, full, meta ) {
                    return ' <img src="'+ data +'" style="width: 100px;height:70px"> ';
                },
            },
            { data: 'title', name: 'title' },
            { data: '_date', name: 'date' },
            { data: '_status', name: '_status' },
            { data: 'action', name: 'action' },
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = "";
                if(column[0][0] == 3){
                    input = '<input type="date" style="width:100%">';
                }else if(column[0][0] == 4){
                    var input = '<?= Utils::getStatusElement() ?>';
                }else if(column[0][0] == 2){
                    input = '<input type="text" style="width:100%">';
                }else{
                    input = '';
                }
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val(), true, true, true).draw();
                });
                t.on( 'order.dt search.dt', function () {
                    t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                } ).draw();
            });
        }
    });
});

</script>
@endpush
