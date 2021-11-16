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
                <h1 class="m-0 text-dark">Create Client SIP</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-sip.index') }}">Client SIPs</a></li>
                    <li class="breadcrumb-item active">Create Client SIP</li>
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
                            <form class="form-horizontal" method="POST" action="{{ route('user-sip.store') }}">

                                {{ csrf_field() }}
                                <?php
                                $fields = [
                                    [
                                        [
                                            'name' => 'user_id',
                                            'type' => 'select',
                                            'label' => UserSipInvestement::attributes('user_id'),
                                            'prompt' => 'Select ',
                                            'options' => UserSipInvestement::optionsForUserId(),
                                            'value' => ''
                                        ],
                                        [
                                            'name' => 'investment_through',
                                            'type' => 'select',
                                            'label' => UserSipInvestement::attributes('investment_through'),
                                            'options' => UserSipInvestement::optionsForInvestmentThrough(),
                                            'prompt' => 'Select ' . UserSipInvestement::attributes('investment_through'),
                                            'value' => ''
                                        ],
                                    ],
                                    [
                                        [
                                            'name' => 'matual_fund_id',
                                            'type' => 'select',
                                            'label' => UserSipInvestement::attributes('matual_fund_id'),
                                            'options' => UserSipInvestement::optionsForMutualFundId(),
                                            'prompt' => 'Select ' . UserSipInvestement::attributes('matual_fund_id'),
                                            'value' => ''
                                        ],
                                        [
                                            'name' => 'sip_amount',
                                            'type' => 'number',
                                            'label' => UserSipInvestement::attributes('sip_amount'),
                                            'value' => ''
                                        ],
                                    ],
                                    [
                                        [
                                            'name' => 'time_period',
                                            'type' => 'select',
                                            'label' => UserSipInvestement::attributes('time_period'),
                                            'options' => UserSipInvestement::optionsForTimePeriod(),
                                            'prompt' => 'Select ' . UserSipInvestement::attributes('time_period'),
                                            'value' => '',
                                            'col' => 6
                                        ],
                                        [
                                            'name' => 'investment_for_year',
                                            'type' => 'number',
                                            'label' => UserSipInvestement::attributes('investment_for_year'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'investment_for_month',
                                            'type' => 'number',
                                            'label' => UserSipInvestement::attributes('investment_for_month'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                    ],
                                    [
                                        [
                                            'name' => 'folio_no',
                                            'type' => 'text',
                                            'label' => UserSipInvestement::attributes('folio_no'),
                                            'value' => '',
                                        ],
                                        [
                                            'name' => 'start_date',
                                            'type' => 'datepicker',
                                            'label' => UserSipInvestement::attributes('start_date'),
                                            'date-format' => 'DD-MM-YYYY',
                                            'value' => '',
                                        ],
                                    ]

                                ];
                                ?>

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
@push('scripts')
<script>
    $(document).ready(function() {
        load_form_data.select_tag('add_user_sip', 'user_id', 'get_all_clients');
    })

    var $disabledResults = $("#user_id");
    $disabledResults.select2();


    var $disabledResults = $("#matual_fund_id");
    $disabledResults.select2();
</script>
@endpush