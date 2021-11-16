<?php 
    use App\MutualFundInvestmentHist;
    use App\UserSipInvestement;
    use App\Utils;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Varify Instalment</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-sip.index') }}">Client SIPs</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-sip.show', $sip['id']) }}">SIP : {{ $sip['folio_no'] }}</a></li>
                    <li class="breadcrumb-item active">Varify Instalment</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
    <div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-2">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="text-danger">Varify Instalment Details
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Due date</th>
                            <td><?= Utils::getFormatedDate($due_date) ?></td>
                        </tr>
                        <tr>
                            <th>{{ UserSipInvestement::attributes('user_id') }}</th>
                            <td><?= $sip->user->name ?></td>
                        </tr>
                        <tr>
                            <th>{{ UserSipInvestement::attributes('folio_no') }}</th>
                            <td><?= $sip->folio_no ?></td>
                        </tr>
                        <tr>
                            <th>{{ MutualFundInvestmentHist::attributes('investment_amount') }}</th>
                            <td><?= $details['investment_amount'] ?></td>
                        </tr>
                        <tr>
                            <th>{{ MutualFundInvestmentHist::attributes('nav_on_date') }}</th>
                            <td><?= $details['nav_on_date'] ?></td>
                        </tr>
                        <tr>
                            <th>{{ MutualFundInvestmentHist::attributes('invested_date') }}</th>
                            <td><?= $details['invested_date'] ?></td>
                        </tr>
                        <tr style="font-size:x-large">
                            <th>{{ MutualFundInvestmentHist::attributes('purchased_units') }}</th>
                            <td><?= Utils::numberFormatedValue($details['purchased_units']) ?></td>
                        </tr>
                        <tr>
                            <td colspan="100%">
                                <a class="btn btn-danger btn-lg float-right" href="{{ route('user-sip.show', $sip['id']) }}">Cancel</a>                                

                                <form class="form-horizontal" method="POST" action="{{ route('user-sip.store-instalment', $sip['id']) }}">
                                    {{ csrf_field() }}
                                    @php
                                        $fields = [
                                            [
                                                [
                                                    'name' => 'investment_amount', 
                                                    'type' => 'number', 
                                                    'label' => MutualFundInvestmentHist::attributes('investment_amount'), 
                                                    'value' => $details['investment_amount']
                                                ],
                                                [
                                                    'name' => 'nav_on_date', 
                                                    'type' => 'number', 
                                                    'label' => MutualFundInvestmentHist::attributes('nav_on_date'), 
                                                    'value' => $details['nav_on_date']
                                                ],
                                            ],
                                            [
                                                [
                                                    'name' => 'invested_date', 
                                                    'type' => 'datepicker', 
                                                    'label' => MutualFundInvestmentHist::attributes('invested_date'), 
                                                    'date-format'=> 'DD-MM-YYYY',
                                                    'value' => $details['invested_date'],
                                                ],
                                                [
                                                    'name' => 'remarks', 
                                                    'type' => 'textarea', 
                                                    'label' => MutualFundInvestmentHist::attributes('remarks'), 
                                                    'value' => $details['remarks']
                                                ],
                                            ],
                                        ];
                                    @endphp
                                    <div class="d-none">
                                        @include('layouts.form', ['form' => $fields])
                                    </div>
            
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success btn-lg float-right mr-1">
                                            Confirm Instalment
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</section>

@endsection