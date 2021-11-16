<?php

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
                <h1 class="m-0 text-dark">Client SIP : {{$sip['folio_no']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-sip.index') }}">Client SIPs</a></li>
                    <li class="breadcrumb-item active">Client SIP</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            {{Utils::successAndFailMessage()}}
                            <a href="{{route('user-sip.edit', $sip['id'])}}" class="btn btn-sm btn-primary">Edit</a>
                            {!! Utils::deleteBtn(route('user-sip.destroy', $sip['id'])) !!}
                            <?php if(!empty($instalments['instalments'])):  ?>
                                <a href="{{route('user-sip.add-instalment', $sip['id'])}}" class="btn btn-sm float-right btn-success">
                                Add Installment (<?= Utils::getFormatedDate($instalments['instalments'][0]) ?>)</a>
                            <?php endif; ?>
                            <table class="table mt-2">
                                <tr>
                                    <th>{{ UserSipInvestement::attributes('folio_no') }}</th>
                                    <td>{{ $sip['folio_no'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ UserSipInvestement::attributes('user_id') }}</th>
                                    <td>{{ $sip['user']['name'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ UserSipInvestement::attributes('matual_fund_id') }}</th>
                                    <td>{{ $sip['mutual_fund']['name'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ UserSipInvestement::attributes('sip_amount') }}</th>
                                    <td>{{ $sip['sip_amount'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ UserSipInvestement::attributes('start_date') }}</th>
                                    <td>{{ Utils::getFormatedDate($sip['start_date']) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ UserSipInvestement::attributes('investment_for') }}</th>
                                    <td>{{ $sip['investment_for'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ UserSipInvestement::attributes('invested_amount') }}</th>
                                    <td>{{ $sip['invested_amount'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <?php if(!empty($missed_instalments) ): ?>
                  <div class="card">
                      <div class="card-header border-0 bg-danger">
                        <h3 class="card-title">
                            <span class="badge bg-warning"><?= count($missed_instalments) ?></span> <b> Missed Installments to Pay</b>  </h3>
                      </div>
                      <div class="card-body">
                        <table class="table table-striped table-valign-middle" id="missedInstalments">
                          <thead>
                          <tr>
                            <th>Due dates</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php foreach ($missed_instalments as $key => $value) : ?>
                          <tr>
                            <td>
                              <?= Utils::getFormatedDate($value) ?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
  
                          </tbody>
                        </table>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="mb-1">SIP Instalment History</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive table-bordered" id="sip_instalment_list">
                                <thead>
                                    <tr>
                                        <th><?= MutualFundInvestmentHist::attributes('id') ?> </th>
                                        <th><?= MutualFundInvestmentHist::attributes('investment_amount') ?> </th>
                                        <th><?= MutualFundInvestmentHist::attributes('nav_on_date') ?> </th>
                                        <th><?= MutualFundInvestmentHist::attributes('invested_date') ?> </th>
                                        <th><?= MutualFundInvestmentHist::attributes('remarks') ?> </th>
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
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(function() {
    $('#sip_instalment_list').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('user-sip.instalment.index', $sip['id']) !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'investment_amount', name: 'investment_amount', className: 'text-right'  },
            { data: 'nav_on_date', name: 'nav_on_date', className: 'text-right' },
            { data: '_invested_date', name: 'invested_date' },
            { data: 'remarks', name: 'remarks' },
            { data: 'action', name: 'action' },
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = "";
                if(column[0][0] == 3){
                    input = '<input type="date" style="width:100%">';
                }else{
                    input = '<input type="text" style="width:100%">';
                }
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val(), false, false, true).draw();
                });
            });
        }
    });
});
</script>
@endpush
