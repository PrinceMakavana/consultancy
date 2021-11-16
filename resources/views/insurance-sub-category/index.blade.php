<?php

use App\InsuranceCategory;
use App\InsuranceSubCategory;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Insurance Sub Categories</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Insurance Sub Categories</li>
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
            <a href="{{ route('sub-category.create') }}" class="btn btn-sm btn-success">Add</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-bordered" id="sub_category_table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th><?= InsuranceSubCategory::attributes('category_id') ?></th>
                            <th><?= InsuranceSubCategory::attributes('name') ?></th>
                            <th><?= InsuranceSubCategory::attributes('status') ?></th>
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
    var t = $('#sub_category_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('sub-category.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: '_category_id', name: 'category_id' },
            { data: 'name', name: 'name' },
            { data: '_status', name: 'status' },
            { data: 'action', name: 'action' },
            
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                if(column[0][0] == 0){
                    var input = '';
                }else if(column[0][0] == 1){
                    var input = '<?= single_quote(Utils::getFilterSelectElement(InsuranceCategory::getInsuranceCategories())) ?>';
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
