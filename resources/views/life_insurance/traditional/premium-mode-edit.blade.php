<?php

use App\Utils;
use App\InsuranceField;
use App\MutualFundType;
use App\InsuranceFieldDetail;
use App\LifeInsuranceTraditional;
use App\InsuranceInstallmentModeHist;
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
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-traditional.index') }}"><?= Utils::titles('life_traditional_insurance') ?></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-traditional.show', ['policy_id' => $policy->id] ) }}">
                            {{$policy['policy_no']}}
                        </a></li>

                    <li class="breadcrumb-item active">Change Premium Mode</li>
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
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" action="<?= route('life-traditional.premium-mode.update', ['policy_id' => $policy->id]) ?>">
                                {{ csrf_field() }}
                                <?php
                                $fields = [
                                    [
                                        [
                                            'name' => 'from_date',
                                            'type' => 'select',
                                            'label' => InsuranceInstallmentModeHist::attributes('from_date'),
                                            'options_dynamic' => InsuranceInstallmentModeHist::optionForFromDateTraditional($policy->id),
                                            'prompt' => 'Select ' . InsuranceInstallmentModeHist::attributes('from_date'),
                                            'value' => '',
                                        ],
                                        [
                                            'name' => 'premium_mode',
                                            'type' => 'select',
                                            'label' => LifeInsuranceTraditional::attributes('premium_mode'),
                                            'options' => LifeInsuranceTraditional::optionsForPremiumMode(),
                                            'prompt' => 'Select ' . LifeInsuranceTraditional::attributes('premium_mode'),
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
    </div>

</section>

@endsection

@push('scripts')
@endpush