<?php

use App\InsuranceField;
use App\MutualFundType;
use App\LifeInsuranceUlip;
use App\InsuranceFieldDetail;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Ulip Insurance</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-ulip.index') }}">User Ulip Insurance</a></li>
                    <li class="breadcrumb-item active">Create Ulip Insurance</li>
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
                            <form class="form-horizontal" method="POST" action="{{ route('life-insurance-ulip.store') }}">
                                {{ csrf_field() }}
                                <?php
                                $fields = [
                                    [
                                        [
                                            'name' => 'user_id',
                                            'type' => 'select',
                                            'label' => LifeInsuranceUlip::attributes('user_id'),
                                            'options' => LifeInsuranceUlip::optionsForUserId(),
                                            'prompt' => 'Select '.LifeInsuranceUlip::attributes('user_id'),
                                            'value' => 'LifeInsuranceUlip::optionsForOnlyUserId()',
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'investment_through',
                                            'type' => 'select',
                                            'label' => LifeInsuranceUlip::attributes('investment_through'),
                                            'options' => Utils::getAmc(),
                                            'prompt' => 'Select '.LifeInsuranceUlip::attributes('investment_through'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'company_id',
                                            'type' => 'select',
                                            'label' => LifeInsuranceUlip::attributes('company_id'),
                                            'options' => LifeInsuranceUlip::optionsForCompanyId(),
                                            'prompt' => 'Select '.LifeInsuranceUlip::attributes('company_id'),
                                            'value' => LifeInsuranceUlip::optionsForOnlyCompanyId(),
                                        ],
                                    ],


                                    [
                                        [
                                            'name' => 'plan_name',
                                            'type' => 'text',
                                            'label' => LifeInsuranceUlip::attributes('plan_name'),
                                            'value' => '',
                                            'col' => 4
                                        ],
                                        [
                                            'name' => 'nav',
                                            'type' => 'number',
                                            'label' => LifeInsuranceUlip::attributes('nav'),
                                            'value' => '',
                                            'col' => 2
                                        ],

                                        [
                                            'name' => 'policy_no',
                                            'type' => 'text',
                                            'label' => LifeInsuranceUlip::attributes('policy_no'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'sum_assured',
                                            'type' => 'number',
                                            'label' => LifeInsuranceUlip::attributes('sum_assured'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                    ],

                                [
                                    [
                                        'name' => 'premium_amount',
                                        'type' => 'number',
                                        'label' => LifeInsuranceUlip::attributes('premium_amount'),
                                        'value' => '',
                                        'col' => 3
                                    ],
                                    [
                                        'name' => 'permium_paying_term',
                                        'type' => 'number',
                                        'suggestion' => "in years",
                                        'warn' => "Min 5 year",
                                        'label' => LifeInsuranceUlip::attributes('permium_paying_term'),
                                        'value' => '',
                                        'col' => 3
                                    ],
                                    [
                                        'name' => 'policy_term',
                                        'type' => 'number',
                                        'suggestion' => "in years",
                                        'label' => LifeInsuranceUlip::attributes('policy_term'),
                                        'value' => '',
                                        'col' => 2
                                    ],
                                    [
                                        'name' => 'premium_mode',
                                        'type' => 'select',
                                        'label' => LifeInsuranceUlip::attributes('premium_mode'),
                                        'options' => LifeInsuranceUlip::optionsForPremiumMode(),
                                        'prompt' => 'Select '.LifeInsuranceUlip::attributes('premium_mode'),
                                        'value' => LifeInsuranceUlip::optionsForPremiumMode(),
                                        'col' => 4,
                                    ],
                                ],

                                [
                                    [
                                        'name' => 'issue_date',
                                        'type' => 'datepicker',
                                        'label' => LifeInsuranceUlip::attributes('issue_date'),
                                        'date-format'=> 'DD-MM-YYYY',
                                        'value' => '',
                                        'col' => 4,
                                    ],
                                    // [
                                    //     'name' => 'maturity_date',
                                    //     'type' => 'datepicker',
                                    //     'type' => 'datepicker',
                                    //     'label' => LifeInsuranceUlip::attributes('maturity_date'),
                                    //     'date-format'=> 'DD-MM-YYYY',
                                    //     'value' => '',
                                    //     'col' => 4,
                                    // ],
                                    // [
                                    //     'name' => 'maturity_amount',
                                    //     'type' => 'number',
                                    //     'label' => LifeInsuranceUlip::attributes('maturity_amount'),
                                    //     'value' => '',
                                    //     'col' => 4
                                    // ],
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

@endsection

@push('scripts')
<script>
    $('#state').on('change', function(e){
        console.log(e);
        var state_id = e.target.value;

        $.get('{{ url('information') }}/create/ajax-state?state_id=' + state_id, function(data) {
            console.log(data);
            $('#city').empty();
            $.each(data, function(index,subCatObj){
                $('#city').append(''+subCatObj.name+'');
            });
        });
    });


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
