<?php

use App\InsuranceCompany;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= Utils::titles('insurance_companies') ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?= Utils::titles('insurance_companies') ?></li>
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
            <a href="{{ route('insurance-company.create') }}" class="btn btn-sm btn-success">Add</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-bordered" id="company_table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th><?= InsuranceCompany::attributes('name') ?></th>
                            <th><?= InsuranceCompany::attributes('image') ?></th>
                            <th><?= InsuranceCompany::attributes('status') ?></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
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
    var t = $('#company_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('insurance-company.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: '_image', name: 'image' ,
                render: function( data, type, full, meta ) {
                    return ' <img src="'+ data +'" style="width: 100px;height:auto"> ';
                },
            },
            { data: '_status', name: 'status' },
            { data: 'action', name: 'action' },
            
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                if(column[0][0] == 1){
                    var input = document.createElement("input");
                }else if(column[0][0] == 3){
                    var input = '<?= Utils::getStatusElement() ?>';
                }else{
                    input ='';
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
