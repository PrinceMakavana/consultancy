<?php

use App\Utils;
use App\InsuranceField;
use App\MutualFundType;
use App\InsuranceFieldDetail;
use App\LifeInsuranceTraditional;
use App\InsuranceInstallmentModeHist;
use App\LifeInsuranceUlip;

?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Change Premium Mode</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-ulip.index') }}">Life Insurance Ulip</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-ulip.show', ['policy_id' => $policy->id] ) }}">
                            Policy : {{$policy['policy_no']}}
                        </a></li>

                    <li class="breadcrumb-item active">Change Premium Mode</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="card card-default">
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="<?= route('life-ulip.premium-mode.update', ['policy_id' => $policy->id]) ?>">
                            {{ csrf_field() }}
                            <?php
                            $fields = [
                                [
                                    [
                                        'name' => 'from_date',
                                        'type' => 'select',
                                        'label' => InsuranceInstallmentModeHist::attributes('from_date'),
                                        'options_dynamic' => InsuranceInstallmentModeHist::optionForFromDateUlip($policy->id),
                                        'prompt' => 'Select ' . InsuranceInstallmentModeHist::attributes('from_date'),
                                        'value' => '',
                                    ],
                                    [
                                        'name' => 'premium_mode',
                                        'type' => 'select',
                                        'label' => LifeInsuranceUlip::attributes('premium_mode'),
                                        'options' => LifeInsuranceUlip::optionsForPremiumMode(),
                                        'prompt' => 'Select ' . LifeInsuranceUlip::attributes('premium_mode'),
                                        'value' => '',
                                    ],
                                    [
                                        'name' => 'premium_amount',
                                        'type' => 'number',
                                        'label' => LifeInsuranceTraditional::attributes('premium_amount'),
                                        'value' => '',
                                    ],
                                ]
                            ];
                            ?>

                            @include('layouts.form', ['form' => $fields])
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button class="btn btn-primary text-light">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')
@endpush