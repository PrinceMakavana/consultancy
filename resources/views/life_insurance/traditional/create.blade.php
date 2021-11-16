<?php

use App\InsuranceField;
use App\MutualFundType;
use App\LifeInsuranceTraditional;
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
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-traditional.index') }}"><?= Utils::titles('life_traditional_insurance') ?></a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content" ng-app="app" ng-controller="mainCtrl">
    <div class="container-fluid">
        <div>
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" action="{{ route('life-insurance-traditional.store') }}">
                                {{ csrf_field() }}
                                <?php
                                $fields = [
                                    [
                                        [
                                            'name' => 'user_id',
                                            'type' => 'select',
                                            'label' => LifeInsuranceTraditional::attributes('user_id'),
                                            'options' => LifeInsuranceTraditional::optionsForUserId(),
                                            'prompt' => 'Select ' . LifeInsuranceTraditional::attributes('user_id'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'investment_through',
                                            'type' => 'select',
                                            'label' => LifeInsuranceTraditional::attributes('investment_through'),
                                            'options' => Utils::getAmc(),
                                            'prompt' => 'Select ' . LifeInsuranceTraditional::attributes('investment_through'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'company_id',
                                            'type' => 'select',
                                            'label' => LifeInsuranceTraditional::attributes('company_id'),
                                            'options' => LifeInsuranceTraditional::optionsForCompanyId(),
                                            'prompt' => 'Select ' . LifeInsuranceTraditional::attributes('company_id'),
                                            'value' => LifeInsuranceTraditional::optionsForOnlyCompanyId(),
                                        ],
                                    ],
                                    [
                                        [
                                            'name' => 'plan_name',
                                            'type' => 'text',
                                            'label' => LifeInsuranceTraditional::attributes('plan_name'),
                                            'value' => '',
                                            'col' => 6
                                        ],

                                        [
                                            'name' => 'policy_no',
                                            'type' => 'text',
                                            'label' => LifeInsuranceTraditional::attributes('policy_no'),
                                            'value' => '',
                                            'col' => 2
                                        ],
                                        [
                                            'name' => 'sum_assured',
                                            'type' => 'number',
                                            'label' => LifeInsuranceTraditional::attributes('sum_assured'),
                                            'value' => '',
                                            'col' => 4
                                        ],
                                    ],

                                    [
                                        [
                                            'name' => 'premium_amount',
                                            'type' => 'number',
                                            'label' => LifeInsuranceTraditional::attributes('premium_amount'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'permium_paying_term',
                                            'type' => 'number',
                                            'suggestion' => "in years",
                                            'label' => LifeInsuranceTraditional::attributes('permium_paying_term'),
                                            'value' => '',
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'policy_term',
                                            'type' => 'number',
                                            'suggestion' => "in years",
                                            'label' => LifeInsuranceTraditional::attributes('policy_term'),
                                            'value' => '',
                                            'col' => 2
                                        ],
                                        [
                                            'name' => 'premium_mode',
                                            'type' => 'select',
                                            'label' => LifeInsuranceTraditional::attributes('premium_mode'),
                                            'options' => LifeInsuranceTraditional::optionsForPremiumMode(),
                                            'prompt' => 'Select ' . LifeInsuranceTraditional::attributes('premium_mode'),
                                            'value' => LifeInsuranceTraditional::optionsForPremiumMode(),
                                            'col' => 4,
                                        ],
                                    ],

                                    [
                                        [
                                            'name' => 'issue_date',
                                            'type' => 'datepicker',
                                            'label' => LifeInsuranceTraditional::attributes('issue_date'),
                                            'date-format' => 'DD-MM-YYYY',
                                            'value' => '',
                                        ],
                                        [
                                            'name' => 'maturity_date',
                                            'type' => 'datepicker',
                                            'label' => LifeInsuranceTraditional::attributes('maturity_date'),
                                            'date-format' => 'DD-MM-YYYY',
                                            'value' => '',
                                        ],
                                    ],
                                    [
                                        [
                                            'name' => 'maturity_amount',
                                            'type' => 'number',
                                            'label' => LifeInsuranceTraditional::attributes('maturity_amount'),
                                            'value' => '',
                                        ],
                                        [
                                            'name' => 'maturity_amount_8_per',
                                            'type' => 'number',
                                            'label' => LifeInsuranceTraditional::attributes('maturity_amount_8_per'),
                                            'value' => '',
                                        ],
                                    ]
                                ];
                                ?>

                                @include('layouts.form', ['form' => $fields])

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
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
<script>
    $('#state').on('change', function(e) {
        console.log(e);
        var state_id = e.target.value;

        $.get('<?= url('information') ?>/create/ajax-state?state_id=' + state_id,
            function(data) {
                console.log(data);
                $('#city').empty();
                $.each(data, function(index, subCatObj) {
                    $('#city').append('' + subCatObj.name + '');
                });
            });
    });

    // $(document).ready(function() {
    //     $('input[id=]').daterangepicker({
    //         singleDatePicker: true,
    //         locale: {
    //             format: '<?= !empty($v["date-format"]) ? $v["date-format"] : "DD/MM/YYYY"  ?>'
    //         }
    //     });
    // })



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

    function setMaturityDate(){
        let issue_date = $('input#issue_date').val();
        let policy_term = $('input#policy_term').val();

        if(issue_date && policy_term){
            issue_date = moment(issue_date, 'DD-MM-YYYY');
            let maturity_date = issue_date.add(policy_term , 'year')
            $('input#maturity_date').val(maturity_date.format('DD-MM-YYYY'))
        }
    }
    
    $(document).ready(function() {
        $('input#issue_date').change(setMaturityDate);
        $('input#policy_term').change(setMaturityDate);   
    })
</script>
@endpush