<?php

use App\MutualFundType;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Mutual Fund Types</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Mutual Fund Types</li>
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
            <a href="{{ route('type.create') }}" class="btn btn-sm btn-success">Add</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-bordered" id="type_table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th><?= MutualFundType::attributes('name') ?></th>
                            <th><?= MutualFundType::attributes('main_type') ?></th>
                            <th><?= MutualFundType::attributes('status') ?></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
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
    var t = $('#type_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= route('type.data') ?>',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: '_main_type', name: 'main_type' },
            { data: '_status', name: 'status' },
            { data: 'action', name: 'action' },
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                if(column[0][0] == 0){
                    var input = '';
                }else if(column[0][0] == 2){
                    var input = '<?= single_quote(Utils::getFilterSelectElement(Utils::getMainTypes())) ?>';
                }else if(column[0][0] == 3){
                    var input = '<?= Utils::getStatusElement() ?>';
                }else{
                    var input = document.createElement("input");
                }
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val(), false, false,false, true).draw();
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
