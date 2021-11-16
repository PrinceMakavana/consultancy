<?php

use App\PolicyMaster;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= Utils::titles('general_insurance') ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?= Utils::titles('general_insurance') ?></li>
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
                <a href="{{ route('policy.create') }}" class="btn btn-sm btn-success">Add</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-bordered" id="type_table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th><?= PolicyMaster::attributes('user_id') ?></th>
                            <th><?= PolicyMaster::attributes('plan_name') ?></th>
                            <th><?= PolicyMaster::attributes('company_id') ?></th>
                            <th><?= PolicyMaster::attributes('premium_amount') ?></th>
                            <th><?= PolicyMaster::attributes('status') ?></th>
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
            ajax: '<?= route('policy.data') ?>',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user_name',
                    name: 'name'
                },
                {
                    data: 'plan_name',
                    name: 'plan_name'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'premium_amount',
                    name: 'premium_amount',
                    className: 'text-right'
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
                    } else if (column[0][0] == 3) {
                        var input = '<?= single_quote(Utils::OptionForCompany()) ?>';
                    } else if (column[0][0] == 5) {
                        var input = '<?= single_quote(Utils::getFilterSelectElement(PolicyMaster::optionForStatus())) ?>';
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