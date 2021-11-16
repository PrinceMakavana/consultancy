<?php

use App\InsuranceField;
use App\MutualFundType;
use App\PolicyMaster;
use App\InsuranceFieldDetail;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('policy.index') }}"><?= Utils::titles('general_insurance') ?></a></li>
                    <li class="breadcrumb-item active">Create</li>
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
                            <form class="form-horizontal" method="POST" action="{{ route('policy.store') }}">
                                {{ csrf_field() }}
                                <?php
                                $fields = [
                                    [
                                        [
                                            'name' => 'user_id',
                                            'type' => 'select',
                                            'label' => PolicyMaster::attributes('user_id'),
                                            'options' => PolicyMaster::optionsForUserId(),
                                            'prompt' => 'Select ' . PolicyMaster::attributes('user_id'),
                                            'value' => PolicyMaster::optionsForOnlyUserId(),
                                        ],
                                        [
                                            'name' => 'company_id',
                                            'type' => 'select',
                                            'label' => PolicyMaster::attributes('company_id'),
                                            'options' => PolicyMaster::optionsForCompanyId(),
                                            'prompt' => 'Select ' . PolicyMaster::attributes('company_id'),
                                            'value' => PolicyMaster::optionsForOnlyCompanyId(),
                                        ],
                                    ],
                                    [
                                        [
                                            'name' => 'insurance_field_id',
                                            'type' => 'select',
                                            'label' => InsuranceFieldDetail::attributes('insurance_field_id'),
                                            'options' => InsuranceField::getInsuranceFields(true),
                                            'prompt' => 'Select ' . InsuranceFieldDetail::attributes('insurance_field_id'),
                                            'value' => ''
                                        ],
                                        [
                                            'name' => 'investment_through',
                                            'type' => 'select',
                                            'label' => PolicyMaster::attributes('investment_through'),
                                            'options' => Utils::getAmc(),
                                            'prompt' => 'Select ' . PolicyMaster::attributes('investment_through'),
                                            'value' => '',
                                        ],
                                    ],

                                    [
                                        [
                                            'name' => 'plan_name',
                                            'type' => 'text',
                                            'label' => PolicyMaster::attributes('plan_name'),
                                            'value' => '',
                                            'col' => 6
                                        ],

                                        [
                                            'name' => 'policy_no',
                                            'type' => 'number',
                                            'label' => PolicyMaster::attributes('policy_no'),
                                            'value' => '',
                                            'col' => 2
                                        ],
                                        [
                                            'name' => 'sum_assured',
                                            'type' => 'number',
                                            'label' => PolicyMaster::attributes('sum_assured'),
                                            'value' => '',
                                            'col' => 4
                                        ],
                                    ],

                                    [
                                        [
                                            'name' => 'premium_amount',
                                            'type' => 'number',
                                            'label' => PolicyMaster::attributes('premium_amount'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'permium_paying_term',
                                            'type' => 'number',
                                            'suggestion' => "in years",
                                            'label' => PolicyMaster::attributes('permium_paying_term'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'policy_term',
                                            'type' => 'number',
                                            'suggestion' => "in years",
                                            'label' => PolicyMaster::attributes('policy_term'),
                                            'value' => '',
                                            'col' => 2
                                        ],
                                        [
                                            'name' => 'premium_mode',
                                            'type' => 'select',
                                            'label' => PolicyMaster::attributes('premium_mode'),
                                            'options' => PolicyMaster::optionsForPremiumMode(),
                                            'prompt' => 'Select ' . PolicyMaster::attributes('premium_mode'),
                                            'value' => PolicyMaster::optionsForPremiumMode(),
                                            'col' => 4,
                                        ],
                                    ],

                                    [
                                        [
                                            'name' => 'issue_date',
                                            'type' => 'datepicker',
                                            'label' => PolicyMaster::attributes('issue_date'),
                                            'date-format' => 'DD-MM-YYYY',
                                            'value' => '',
                                        ],

                                    ],


                                ];
                                ?>

                                @include('layouts.form', ['form' => $fields])

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Next
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


    var $disabledResults = $("#company_id");
    $disabledResults.select2();

    var $disabledResults = $("#category_id");
    $disabledResults.select2();

    var $disabledResults = $("#sub_category_id");
    $disabledResults.select2();

    var $disabledResults = $("#insurance_field_id");
    $disabledResults.select2();
</script>
@endpush