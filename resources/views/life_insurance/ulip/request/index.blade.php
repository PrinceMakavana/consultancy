<?php

use App\LifeInsuranceUlip;
use App\UlipActualValueRequest;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Actual Value Requests</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('life-insurance-ulip.index') }}">Ulip Life Insurance</a>
                    </li>
                    <li class="breadcrumb-item active">Actual Value Requests</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                {{Utils::successAndFailMessage()}}
                <table class="table table-responsive table-bordered" id="list_table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th><?= UlipActualValueRequest::attributes('request_by') ?></th>
                            <th><?= UlipActualValueRequest::attributes('policy_id') ?></th>
                            <th><?= UlipActualValueRequest::attributes('created_at') ?></th>
                            <th><?= UlipActualValueRequest::attributes('status') ?></th>
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
        var t = $('#list_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= route('life-insurance-ulip.actual-value-request.data') ?>',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'plan_name',
                    name: 'plan_name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                },

            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    if (column[0][0] == 0) {
                        var input = '';
                    } else if (column[0][0] == 4) {
                        var input = '<?= single_quote(Utils::getFilterSelectElement(UlipActualValueRequest::optionsForStatus())) ?>';
                    } else if (column[0][0] == 5) {
                        var input = '';
                    } else {
                        var input = document.createElement("input");
                    }
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val(), false, false, false, true).draw();
                        });
                    t.on('order.dt search.dt', function() {
                        t.column(0, {
                            search: 'applied',
                            order: 'applied'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                });
            }
        });
    });
</script>
@endpush