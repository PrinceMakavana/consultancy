<?php

use App\UserLampSumInvestment;
    use App\UserSipInvestement;
    use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Client Lump Sum Investments</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Client Lump Sum Investments</li>
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
            <a href="{{ route('user-lump-sum.create') }}" class="btn btn-sm btn-success">Add</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-bordered" id="user_sip_table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th><?= UserLampSumInvestment::attributes('user_id') ?></th>
                            <th><?= UserLampSumInvestment::attributes('folio_no') ?></th>
                            <th><?= UserLampSumInvestment::attributes('matual_fund_id') ?></th>
                            <th><?= UserLampSumInvestment::attributes('invested_amount') ?></th>
                            <th><?= UserLampSumInvestment::attributes('invested_at') ?></th>
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
        ajax: '{!! route('user-lump-sum.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: data => `${data.user_name} (${data.user_id})`, name: 'user_name' },
            { data: 'folio_no', name: 'folio_no' },
            { data: 'mutual_fund_name', name: 'mutual_fund_name' },
            { data: 'invested_amount', name: 'invested_amount', className: 'text-right' },
            { data: '_invested_at', name: 'invested_at' },
            { data: 'action', name: 'action' },
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = "";
                if(column[0][0] == 0){
                    input = '';
                }else 
                if(column[0][0] == 5){
                    input = '<input type="date" style="width:100%">';
                }else{
                    input = '<input type="text" style="width:100%">';
                }
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val(), false, false, true).draw();
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
