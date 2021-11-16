<?php

use App\InsuranceField;
use App\InsuranceFieldDetail;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Insurance Field Detail</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Insurance Field Detail</li>
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
            <a href="{{ route('field-detail.create') }}" class="btn btn-sm btn-success">Add</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-bordered" id="field_table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th><?= InsuranceFieldDetail::attributes('insurance_field_id') ?></th>
                            <th><?= InsuranceFieldDetail::attributes('fieldname') ?></th>
                            <th><?= InsuranceFieldDetail::attributes('status') ?></th>
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
    var t = $('#field_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('field-detail.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: '_insurance_field_id', name: 'insurance_field_id' },
            { data: 'fieldname', name: 'fieldname' },
            { data: '_status', name: 'status' },
            { data: 'action', name: 'action' },
            
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                if(column[0][0] == 0){
                    var input = '';
                }else if(column[0][0] == 1){
                    var input = '<?= single_quote(Utils::getFilterSelectElement(InsuranceField::getInsuranceFields())) ?>';
                }else if(column[0][0] == 2){
                    var input = document.createElement("input");
                }else if(column[0][0] == 3){
                    var input = '<?= Utils::getStatusElement() ?>';
                }else{
                    var input = '';
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
