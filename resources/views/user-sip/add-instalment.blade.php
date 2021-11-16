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
                <h1 class="m-0 text-dark">Add Instalment : <?= Utils::getFormatedDate($due_date) ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-sip.index') }}">Client SIPs</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-sip.show', $sip['id']) }}">SIP : {{ $sip['folio_no'] }}</a></li>
                    <li class="breadcrumb-item active">Add Instalment</li>
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
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('user-sip.varify-instalment', $sip['id']) }}">
                        {{ csrf_field() }}
                        @php
                            $fields = [
                                [
                                    [
                                        'name' => 'investment_amount', 
                                        'type' => 'number', 
                                        'label' => MutualFundInvestmentHist::attributes('investment_amount'), 
                                        'value' => $sip['sip_amount']
                                    ],
                                    [
                                        'name' => 'nav_on_date', 
                                        'type' => 'number', 
                                        'label' => MutualFundInvestmentHist::attributes('nav_on_date'), 
                                        'value' => $sip['mutual_fund']['nav']
                                    ],
                                ],
                                [
                                    [
                                        'name' => 'invested_date', 
                                        'type' => 'datepicker', 
                                        'label' => MutualFundInvestmentHist::attributes('invested_date'), 
                                        'date-format'=> 'DD-MM-YYYY',
                                        'value' => date('d-m-Y', strtotime($due_date)),
                                    ],
                                    [
                                        'name' => 'remarks', 
                                        'type' => 'textarea', 
                                        'label' => MutualFundInvestmentHist::attributes('remarks'), 
                                        'value' => ''
                                    ],
                                ],
                            ];
                        @endphp

                        @include('layouts.form', ['form' => $fields])

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</section>

@endsection