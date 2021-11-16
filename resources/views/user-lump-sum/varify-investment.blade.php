<?php

use App\User;
use App\MutualFund;
use App\MutualFundInvestmentHist;
use App\UserLampSumInvestment;
use App\Utils;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Varify Investment</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-lump-sum.index') }}">Client Lump Sum</a></li>
                    <li class="breadcrumb-item active">Varify Investment</li>
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
                            <h3 class="text-danger">Varify Lump sum Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>{{ UserLampSumInvestment::attributes('user_id') }}</th>
                                    <td><?= User::getUser($details['user_id'])->name ?></td>
                                </tr>
                                <tr>
                                    <th>{{ UserLampSumInvestment::attributes('matual_fund_id') }}</th>
                                    <td><?= MutualFund::getFundDetails($details['matual_fund_id'])->name ?></td>
                                </tr>
                                <tr>
                                    <th>{{ UserLampSumInvestment::attributes('folio_no') }}</th>
                                    <td><?= $details['folio_no'] ?></td>
                                </tr>
                                <tr>
                                    <th>{{ UserLampSumInvestment::attributes('invested_amount') }}</th>
                                    <td><?= Utils::getFormatedAmount($details['invested_amount']) ?></td>
                                </tr>
                                <tr>
                                    <th>{{ UserLampSumInvestment::attributes('nav_on_date') }}</th>
                                    <td><?= Utils::getFormatedAmount($details['nav_on_date']) ?></td>
                                </tr>
                                <tr>
                                    <th>{{ UserLampSumInvestment::attributes('invested_at') }}</th>
                                    <td><?= Utils::getFormatedDate($details['invested_at']) ?></td>
                                </tr>
                                <tr style="font-size:x-large">
                                    <th>{{ UserLampSumInvestment::attributes('units') }}</th>
                                    <td><?= $details['units'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="100%">
                                        <a class="btn btn-danger btn-lg float-right" href="{{ route('user-lump-sum.index') }}">Cancel</a>

                                        <form class="form-horizontal" method="POST" action="{{ route('user-lump-sum.store') }}">
                                            {{ csrf_field() }}
                                            <?php
                                            $fields = [
                                                [
                                                    [
                                                        'name' => 'user_id',
                                                        'type' => 'select',
                                                        'label' => UserLampSumInvestment::attributes('user_id'),
                                                        'options' => UserLampSumInvestment::optionsForUserId(),
                                                        'prompt' => 'Select ' . UserLampSumInvestment::attributes('user_id'),
                                                        'value' => $details['user_id']
                                                    ],
                                                    [
                                                        'name' => 'investment_through',
                                                        'type' => 'select',
                                                        'label' => UserLampSumInvestment::attributes('investment_through'),
                                                        'options' => UserLampSumInvestment::optionsForInvestmentThrough(),
                                                        'prompt' => 'Select ' . UserLampSumInvestment::attributes('investment_through'),
                                                        'value' => $details['investment_through']
                                                    ],
                                                ],
                                                [
                                                    [
                                                        'name' => 'matual_fund_id',
                                                        'type' => 'select',
                                                        'label' => UserLampSumInvestment::attributes('matual_fund_id'),
                                                        'options' => UserLampSumInvestment::optionsForMutualFundId(),
                                                        'prompt' => 'Select ' . UserLampSumInvestment::attributes('matual_fund_id'),
                                                        'value' => $details['matual_fund_id']
                                                    ],
                                                    [
                                                        'name' => 'invested_amount',
                                                        'type' => 'number',
                                                        'label' => UserLampSumInvestment::attributes('invested_amount'),
                                                        'value' => $details['invested_amount']
                                                    ],
                                                ],
                                                [
                                                    [
                                                        'name' => 'nav_on_date',
                                                        'type' => 'number',
                                                        'label' => UserLampSumInvestment::attributes('nav_on_date'),
                                                        'value' => $details['nav_on_date']
                                                    ],
                                                    [
                                                        'name' => 'invested_at',
                                                        'type' => 'datepicker',
                                                        'label' => UserLampSumInvestment::attributes('invested_at'),
                                                        'date-format' => 'DD-MM-YYYY',
                                                        'value' => $details['invested_at'],
                                                    ],
                                                ],
                                                [
                                                    [
                                                        'name' => 'folio_no',
                                                        'type' => 'text',
                                                        'label' => UserLampSumInvestment::attributes('folio_no'),
                                                        'value' => $details['folio_no'],
                                                    ],
                                                ]

                                            ];
                                            ?>
                                            <div class="d-none">
                                                @include('layouts.form', ['form' => $fields])
                                            </div>

                                            <div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-success btn-lg float-right mr-1">
                                                        Confirm Instalment
                                                    </button>
                                                </div>
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