<?php

use App\Utils;
use App\LifeInsuranceUlip;
use App\LifeInsuranceUlipUnitHist;

?>
@extends('layouts.app')

@section('content')

<style>
    /* #withdraw_amount_div,
    #units_div {
        display: none
    } */
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Withdraw Units</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <?php if ($policy->table == LifeInsuranceUlip::$tablename) : ?>
                        <li class="breadcrumb-item">
                            <a href="{{ route('life-insurance-ulip.index') }}">
                                <?= Utils::titles('life_ulip_insurance') ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('life-insurance-ulip.show', ['policy_id' => $policy->id] ) }}">
                                {{$policy['policy_no']}}
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="breadcrumb-item active">Withdraw</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        {{Utils::successAndFailMessage()}}
        <div>
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <h3>Available Units : <?= Utils::numberFormatedValue($policy->units) ?></h3>
                            <?php
                            if ($tbl_key == LifeInsuranceUlip::$tablename) {
                                $url = route('insurance-withdraw-ulip.save',  ['policy_id' => $policy->id, 'tbl_key' => $policy->table]);
                            }
                            ?>
                            <form class="form-horizontal" method="POST" action="{{ $url }}">
                                {{ csrf_field() }}
                                <?php
                                $request = Request();
                                $url =  $request->fullUrl('tbl_key');

                                $otherFields = [];
                                if ($tbl_key == LifeInsuranceUlip::$tablename) {
                                    $otherFields = [
                                        [
                                            'name' => 'nav',
                                            'type' => 'number',
                                            'label' => LifeInsuranceUlip::attributes('nav'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'units',
                                            'type' => 'number',
                                            'label' => LifeInsuranceUlip::attributes('units'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                    ];
                                }

                                $fields = [
                                    [
                                        [
                                            'name' => 'amount',
                                            'type' => 'number',
                                            'label' => LifeInsuranceUlipUnitHist::attributes('amount'),
                                            'value' => $policy['next_premium']['premium_amount']
                                        ],
                                    ],
                                    $otherFields,
                                    [
                                        [
                                            'name' => 'added_at',
                                            'type' => 'datepicker',
                                            'label' => 'Withdraw At',
                                            'date-format' => 'DD-MM-YYYY',
                                            'value' => ''
                                        ],
                                    ],


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
@stop
@push('scripts')

@endpush