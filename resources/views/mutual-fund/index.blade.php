<?php

use App\MutualFund;
use App\MutualFundType;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Mutual Funds</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Mutual Funds</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<style>td:nth-child(8){white-space: nowrap}</style>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            
            {{Utils::successAndFailMessage()}}

            <div class="card-header">
            <a href="{{ route('funds.create') }}" class="btn btn-sm btn-success">Add</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-bordered" id="fund_table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th><?= MutualFund::attributes('name') ?></th>
                            <th><?= MutualFund::attributes('company_id') ?></th>
                            <th><?= MutualFund::attributes('main_type') ?></th>
                            <th><?= MutualFund::attributes('type_id') ?></th>
                            <th><?= MutualFund::attributes('status') ?></th>
                            <th class="text-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-nowrap"></td>
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
    var t = $('#fund_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= route('funds.data') ?>',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: '_company_id', name: 'company_id' },
            { data: '_main_type', name: 'main_type' },
            { data: '_type_id', name: 'type_id' },
            { data: '_status', name: '_status' },
            { data: 'action', name: 'action' },
            
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                if(column[0][0] == 0){
                    var input = '';
                }else if(column[0][0] == 2){
                    var input = '<?= single_quote(Utils::getFilterSelectElement(MutualFund::optionsForCompany())) ?>';
                }else if(column[0][0] == 3){
                    var input = '<?= single_quote(Utils::getFilterSelectElement(Utils::getMainTypes())) ?>';
                }else if(column[0][0] == 4){
                    var input = '<?= single_quote(Utils::getFilterSelectElement(MutualFundType::getMutualFundTypes())) ?>';
                }else if(column[0][0] == 1){
                    var input = document.createElement("input");
                }else if(column[0][0] == 5){
                    var input = '<?= Utils::getStatusElement() ?>';
                }else{
                    // var input = document.createElement("input");
                }
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val(), false, true,true,true,false).draw();
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
