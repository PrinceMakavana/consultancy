<?php

use App\UserLampSumInvestment;
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
                <h1 class="m-0 text-dark">Update Client Lump Sum : {{$lumpsum['folio_no']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-lump-sum.index') }}">Client Lump Sum Investments</a></li>
                    <li class="breadcrumb-item active">Update Client Lump Sum</li>
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
                    {{Utils::successAndFailMessage()}}
                    <form class="form-horizontal" method="POST" action="{{ route('user-lump-sum.update', $lumpsum['id']) }}">
                        {{method_field('PUT')}}
                        {{ csrf_field() }}

                        @php
                            $fields = [
                                [
                                    [
                                        'name' => 'user_id',
                                        'type' => 'select',
                                        'label' => UserLampSumInvestment::attributes('user_id'),
                                        'options' => UserLampSumInvestment::optionsForUserId($lumpsum['user_id']),
                                        'prompt' => 'Select '.UserLampSumInvestment::attributes('user_id'),
                                        'value' => $lumpsum['user_id']
                                    ],
                                    [
                                        'name' => 'investment_through',
                                        'type' => 'select',
                                        'label' => UserLampSumInvestment::attributes('investment_through'),
                                        'options' => UserLampSumInvestment::optionsForInvestmentThrough(),
                                        'prompt' => 'Select '.UserLampSumInvestment::attributes('investment_through'),
                                        'value' => $lumpsum['investment_through']
                                    ],
                                ],
                                [
                                    [
                                        'name' => 'matual_fund_id',
                                        'type' => 'select',
                                        'label' => UserLampSumInvestment::attributes('matual_fund_id'),
                                        'options' => UserLampSumInvestment::optionsForMutualFundId($lumpsum['matual_fund_id']),
                                        'prompt' => 'Select '.UserLampSumInvestment::attributes('matual_fund_id'),
                                        'value' => $lumpsum['matual_fund_id']
                                    ],
                                    [
                                        'name' => 'invested_amount',
                                        'type' => 'number',
                                        'label' => UserLampSumInvestment::attributes('invested_amount'),
                                        'value' => $lumpsum['invested_amount']
                                    ],
                                ],
                                [
                                    [
                                        'name' => 'nav_on_date',
                                        'type' => 'number',
                                        'label' => UserLampSumInvestment::attributes('nav_on_date'),
                                        'value' => $lumpsum['nav_on_date']
                                    ],
                                    [
                                        'name' => 'invested_at',
                                        'type' => 'datepicker',
                                        'label' => UserLampSumInvestment::attributes('invested_at'),
                                        'date-format'=> 'DD-MM-YYYY',
                                        'value' => !empty(strtotime($lumpsum['invested_at'])) ? date('m-d-Y', strtotime($lumpsum['invested_at'])) : '',
                                    ],
                                ],
                                [
                                    [
                                        'name' => 'folio_no',
                                        'type' => 'text',
                                        'label' => UserLampSumInvestment::attributes('folio_no'),
                                        'value' => $lumpsum['folio_no'],
                                    ],
                                    [
                                        'name' => 'remarks',
                                        'type' => 'textarea',
                                        'label' => MutualFundInvestmentHist::attributes('remarks'),
                                        'value' => $hist['remarks']
                                    ],
                                ]

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
@push('scripts')
<script>

var $disabledResults = $("#user_id");
$disabledResults.select2();


var $disabledResults = $("#matual_fund_id");
$disabledResults.select2();

</script>
@endpush
