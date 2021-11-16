<?php

use App\UserSipInvestement;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Client SIPs</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Client SIPs</li>
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
                <a href="{{ route('user-sip.create') }}" class="btn btn-sm btn-success">Add</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-bordered" id="user_sip_table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th><?= UserSipInvestement::attributes('user_id') ?></th>
                            <th><?= UserSipInvestement::attributes('folio_no') ?></th>
                            <th><?= UserSipInvestement::attributes('matual_fund_id') ?></th>
                            <th><?= UserSipInvestement::attributes('sip_amount') ?></th>
                            <th><?= UserSipInvestement::attributes('start_date') ?></th>
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
        var t = $('#user_sip_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= route('user-sip.data') ?>',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: function(data) {
                        return `${data.user_name} (${data.user_id})`;
                    },
                    name: 'user_name'
                },
                {
                    data: 'folio_no',
                    name: 'folio_no'
                },
                {
                    data: 'mutual_fund_name',
                    name: 'mutual_fund_name'
                },
                {
                    data: 'sip_amount',
                    name: 'sip_amount',
                    className: 'text-right'
                },
                {
                    data: '_start_date',
                    name: 'start_date'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var input = "";
                    if (column[0][0] == 0) {
                        input = '';
                    } else if (column[0][0] == 5) {
                        input = '<input type="date" style="width:100%">';
                    } else {
                        input = '<input type="text" style="width:100%">';
                    }
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val(), false, false, true).draw();
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