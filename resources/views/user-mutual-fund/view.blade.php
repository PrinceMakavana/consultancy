<?php

use App\MutualFundUser;

    use App\MutualFundInvestmentHist;
    use App\UserSipInvestement;
    use App\Utils;
    use App\User;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">User Mutual Fund : {{$user_fund['folio_no']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-mutual-fund.index') }}">User Mutual Funds</a>
                    </li>
                    <li class="breadcrumb-item active">User Mutual Fund : {{$user_fund['folio_no']}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="container">
            {{Utils::successAndFailMessage()}}
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">

                            <a href="{{ route('withdraw.create', ['user_fund_id'=>$user_fund->id]) }}"
                                class="btn btn-warning btn-sm">Withdraw</a>
                            <?php if(!empty($user_fund->user_sip)): ?>
                            <a href="{{ route('user-sip.show', $user_fund->user_sip->id) }}"
                                class="btn btn-success btn-sm">View SIP Investment</a>
                            <?php endif; ?>
                            <?php $delete_link = route('user-mutual-fund.destroy', $user_fund->id);
                              $delete = Utils::deleteBtn($delete_link);
                                echo $delete ;
                            ?>
                            {{-- <a href="" class="btn btn-primary btn-sm">View Lump Sum Investment</a> --}}
                            <table class="table mt-2">
                                <tr>
                                    <th>{{ MutualFundUser::attributes('folio_no') }}</th>
                                    <td>{{ $user_fund['folio_no'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ MutualFundUser::attributes('user_id') }}</th>
                                    <td>{{ $user_fund['user']['name'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ MutualFundUser::attributes('matual_fund_id') }}</th>
                                    <td>
                                        <a href="{{ route('funds.show', $user_fund['mutual_fund']['id']) }}" target="_blank">
                                            {{ $user_fund['mutual_fund']['name'] }}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            {{Utils::successAndFailMessage()}}
                            <table class="table mt-2">
                                <tr>
                                    <th>{{ MutualFundUser::attributes('invested_amount') }}</th>
                                    <td class="text-right">{{ number_format($user_fund['invested_amount'], 3, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ MutualFundUser::attributes('current_value') }}</th>
                                    <td class="text-right">{{ number_format($user_fund['current_value'], 3, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ MutualFundUser::attributes('start_date') }}</th>
                                    <td class="text-right">{{ Utils::getFormatedDate($user_fund['start_date']) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ MutualFundUser::attributes('total_units') }}</th>
                                    <td class="text-right">{{ number_format($user_fund['total_units'], 3, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ MutualFundUser::attributes('absolute_return') }}</th>
                                    <td class="text-right">{{ number_format($user_fund['absolute_return'], 3, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ MutualFundUser::attributes('annual_return') }}</th>
                                    <td class="text-right">{{ number_format($user_fund['annual_return'], 3, '.', '') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <h2>History</h2>
                            <table class="table table-responsive table-bordered" id="history">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>{{ MutualFundInvestmentHist::attributes('invested_date') }}</th>
                                        <th>{{ MutualFundInvestmentHist::attributes('investement_type') }}</th>
                                        <th>{{ MutualFundInvestmentHist::attributes('nav_on_date') }}</th>
                                        <th>{{ MutualFundInvestmentHist::attributes('purchased_units') }}</th>
                                        <th>{{ MutualFundInvestmentHist::attributes('investment_amount') }}</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="right"></td>
                                        <td class="right"></td>
                                        <td class="right"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@stop
@push('scripts')
<script>
    $(function() {
    var t = $('#history').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('user.myFundHistory', $user_fund['id']  ) !!}',

        columns: [
            { data: 'id', render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            } },
            { data: '_invested_date', name: 'invested_date'  },
            { data: 'investement_type', name: 'investement_type' },
            { data: 'nav_on_date', name: 'nav_on_date' , className: 'text-right'},
            { data: 'purchased_units', name: 'purchased_units' , className: 'text-right'},
            { data: 'investment_amount', name: 'investment_amount' , className: 'text-right'},
            ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = "";
                if(column[0][0] == 0){
                    input = '';
                }

                else if(column[0][0] == 2){
                    var input = '<?= single_quote(Utils::getInvestmentType()) ?>';
                }
                else{
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
