<?php
    use App\Utils;
    use App\LifeInsuranceUlip;

?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Policy : {{$policy['plan_name']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-ulip.index') }}">User Policy :
                            {{$policy['user']['name']}} </a></li>
                    <li class="breadcrumb-item active">Update Policy</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                                action="{{ route('life-insurance-ulip.update', $policy['id']) }}">
                                {{method_field('PUT')}}
                                {{ csrf_field() }}

                                @php
                                $fields = [
                                [
                                    
                                    [
                                            'name' => 'user_id',
                                            'type' => 'select',
                                            'label' => LifeInsuranceUlip::attributes('user_id'),
                                            'options' => LifeInsuranceUlip::optionsForUserId(),
                                            'prompt' => 'Select '.LifeInsuranceUlip::attributes('user_id'),
                                            'value' => $policy['user_id'],
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'investment_through',
                                            'type' => 'select',
                                            'label' => LifeInsuranceUlip::attributes('investment_through'),
                                            'options' => Utils::getAmc(),
                                            'prompt' => 'Select '.LifeInsuranceUlip::attributes('investment_through'),
                                            'value' => $policy['investment_through'],
                                            'col' => 3
                                        ],
                                        [
                                            'name' => 'company_id',
                                            'type' => 'select',
                                            'label' => LifeInsuranceUlip::attributes('company_id'),
                                            'options' => LifeInsuranceUlip::optionsForCompanyId(),
                                            'prompt' => 'Select '.LifeInsuranceUlip::attributes('company_id'),
                                            'value' => $policy['company_id'],
                                        ],
                                ],

                                [
                                    [
                                        'name' => 'plan_name',
                                        'type' => 'text',
                                        'label' => LifeInsuranceUlip::attributes('plan_name'),
                                        'value' => $policy['plan_name'],
                                        'col' => 6
                                    ],

                                    [
                                        'name' => 'policy_no',
                                        'type' => 'number',
                                        'label' => LifeInsuranceUlip::attributes('policy_no'),
                                        'value' => $policy['policy_no'],
                                        'col' => 2
                                    ],
                                    [
                                        'name' => 'sum_assured',
                                        'type' => 'number',
                                        'label' => LifeInsuranceUlip::attributes('sum_assured'),
                                        'value' => $policy['sum_assured'],
                                        'col' => 4
                                    ],

                                ],

                                [
                                    [
                                        'name' => 'premium_amount',
                                        'type' => 'number',
                                        'label' => LifeInsuranceUlip::attributes('premium_amount'),
                                        'value' => $policy['premium_amount'],
                                        'col' => 3
                                    ],
                                    [
                                        'name' => 'permium_paying_term',
                                        'type' => 'number',
                                        'suggestion' => "in years",
                                        'label' => LifeInsuranceUlip::attributes('permium_paying_term'),
                                        'value' => $policy['permium_paying_term'],
                                        'col' => 3
                                    ],
                                    [
                                        'name' => 'policy_term',
                                        'type' => 'number',
                                        'suggestion' => "in years",
                                        'label' => LifeInsuranceUlip::attributes('policy_term'),
                                        'value' => $policy['policy_term'],
                                        'col' => 2
                                    ],
                                    [
                                        'name' => 'premium_mode',
                                        'type' => 'select',
                                        'label' => LifeInsuranceUlip::attributes('premium_mode'),
                                        'options' => LifeInsuranceUlip::optionsForPremiumMode(),
                                        'prompt' => 'Select '.LifeInsuranceUlip::attributes('premium_mode'),
                                        'value' => $policy['premium_mode'],
                                        'col' => 4,
                                    ],

                                ],
                                
                                [
                                    [
                                        'name' => 'issue_date',
                                        'type' => 'datepicker',
                                        'label' => LifeInsuranceUlip::attributes('issue_date'),
                                        'date-format'=> 'DD-MM-YYYY',
                                        'value' => $policy['issue_date'],
                                        'col' => 4,
                                    ],
                                    [
                                        'name' => 'maturity_date',
                                        'type' => 'datepicker',
                                        'label' => LifeInsuranceUlip::attributes('maturity_date'),
                                        'date-format'=> 'DD-MM-YYYY',
                                        'value' => $policy['maturity_date'],
                                        'col' => 4,
                                    ],
                                    [
                                        'name' => 'maturity_amount',
                                        'type' => 'number',
                                        'label' => LifeInsuranceUlip::attributes('maturity_amount'),
                                        'value' => $policy['maturity_amount'],
                                        'col' => 4
                                    ],
                                ],

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


var $disabledResults = $("#company_id");
$disabledResults.select2();



</script>
@endpush
