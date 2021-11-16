<?php

use App\Utils;
use App\PolicyBenefits;
use App\LifeInsuranceUlip;
use App\LifeInsuranceTraditional;
use App\PolicyMaster;

?>
@extends('layouts.app')

@section('content')

<style>
    #withdraw_amount_div,
    #units_div {
        display: none
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add Benefit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">

                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <?php if ($policy->table == LifeInsuranceUlip::$tablename) : ?>
                        <li class="breadcrumb-item"><a href="{{ route('life-insurance-ulip.index') }}"><?= Utils::titles('life_ulip_insurance') ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('life-insurance-ulip.show', ['policy_id' => $policy->id] ) }}">
                                Policy : {{$policy['policy_no']}}
                            </a>
                        </li>
                    <?php elseif ($policy->table == LifeInsuranceTraditional::$tablename) : ?>
                        <li class="breadcrumb-item"><a href="{{ route('life-insurance-traditional.index') }}"><?= Utils::titles('life_traditional_insurance') ?></a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('life-insurance-traditional.show', ['policy_id' => $policy->id] ) }}">
                                Policy : {{$policy['policy_no']}}
                            </a>
                        </li>
                    <?php elseif ($policy->table == PolicyMaster::$tablename) : ?>
                        <li class="breadcrumb-item"><a href="{{ route('policy.index') }}"><?= Utils::titles('general_insurance') ?></a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('policy.show', ['policy_id' => $policy->id] ) }}">
                                Policy : {{$policy['policy_no']}}
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="breadcrumb-item active">Benefit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div>
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-header">
                            <?= $title ?>
                        </div>
                        <div class="card-body">
                            <?php
                            if ($tbl_key == LifeInsuranceTraditional::$tablename) {
                                $url = route('insurance-benefits-traditional.store',  ['policy_id' => $policy->id, 'tbl_key' => $policy->table]);
                            } else if ($tbl_key == LifeInsuranceUlip::$tablename) {
                                $url = route('insurance-benefits-ulip.store',  ['policy_id' => $policy->id, 'tbl_key' => $policy->table]);
                            } else if ($tbl_key == PolicyMaster::$tablename) {
                                $url = route('insurance-benefits-general.store',  ['policy_id' => $policy->id, 'tbl_key' => $policy->table]);
                            }
                            ?>
                            <form class="form-horizontal" method="POST" action="{{ $url }}">
                                {{ csrf_field() }}
                                <?php
                                $fields = [
                                    [
                                        [
                                            'name' => 'tbl_key',
                                            'type' => 'hidden',
                                            'value' => $tbl_key,
                                        ],
                                        [
                                            'name' => 'benefit_type',
                                            'type' => 'hidden',
                                            'value' => $benefit_type,
                                        ],
                                    ],
                                    [
                                        [
                                            'name' => 'notes',
                                            'type' => 'textarea',
                                            'label' => PolicyBenefits::attributes('notes'),
                                            'value' => '',
                                            'col' => '6'
                                        ],

                                    ],
                                    [
                                        [
                                            'name' => 'amount',
                                            'type' => 'number',
                                            'label' => PolicyBenefits::attributes('amount'),
                                            'suggestion' => $suggestion,
                                            'value' => $amount
                                        ],
                                        [
                                            'name' => 'received_at',
                                            'type' => 'datepicker',
                                            'label' => PolicyBenefits::attributes('received_at'),
                                            'date-format' => 'DD-MM-YYYY',
                                            'value' => ''
                                        ],
                                    ],
                                ];

                                if ($benefit_type == 'death_benefit') {
                                    $fields[] = [
                                        [
                                            'name' => 'date',
                                            'type' => 'datepicker',
                                            'label' => PolicyBenefits::attributes('date'),
                                            'value' => ''
                                        ]
                                    ];
                                } else {
                                    $fields[] = [
                                        [
                                            'name' => 'date',
                                            'type' => 'hidden',
                                            'label' => PolicyBenefits::attributes('date'),
                                            'value' => $date
                                        ]
                                    ];
                                }

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