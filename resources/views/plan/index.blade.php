<?php

use App\Utils;
use App\UserPlan;
use App\UserSipInvestement;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">User Plan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">User Plan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('plan.create') }}" class="btn btn-sm btn-success">Add</a>
                <div class="float-right">
                <?= Utils::getFilterSelectElement(UserSipInvestement::optionsForUserId(), "id='user_filter_' class='float-right'") ?>
                </div>
            </div>
            <div class="card-body">


                {{Utils::successAndFailMessage()}}

                <table class="table table-responsive table-bordered" id="plan_table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th><?= UserPlan::attributes('type') ?></th>
                            <th><?= UserPlan::attributes('user_id') ?></th>
                            <th><?= UserPlan::attributes('target_amount') ?></th>
                            <th><?= UserPlan::attributes('years') ?></th>
                            <th><?= UserPlan::attributes('remaining') ?></th>
                            <th><?= UserPlan::attributes('status') ?></th>
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
    var t;
    $(function() {

        $("#user_filter_").select2()
        $("#user_filter_").change(function(){
            $("#user_filter").val($("#user_filter_").val()).change()
        });

        t = $('#plan_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= route('plan.data') ?>',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: '_type',
                    name: 'type'
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'target_amount',
                    name: 'target_amount'
                },
                {
                    data: '_years',
                    name: '_years'
                },
                {
                    data: '_remaining',
                    name: '_remaining'
                },
                {
                    data: '_status',
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
                    if (column[0][0] == 1) {
                        var input = '<?= single_quote(Utils::getPlanTypes()) ?>';
                    } else if (column[0][0] == 2) {
                        var input = '<?= single_quote(Utils::getFilterSelectElement(UserSipInvestement::optionsForUserId(), "id='user_filter' class='d-none'"))  ?>';
                    } else if (column[0][0] == 6) {
                        var input = '<?= single_quote(Utils::getStatusElement()) ?>';
                    } else {
                        var input = '';
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