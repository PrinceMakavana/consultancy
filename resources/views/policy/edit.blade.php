<?php
    use App\Utils;
    use App\PolicyMaster;
    use App\InsuranceField;
    use App\InsuranceFieldDetail;

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
                    <li class="breadcrumb-item"><a href="{{ route('policy.index') }}">User Policy :
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
                                action="{{ route('policy.update', $policy['id']) }}">
                                {{method_field('PUT')}}
                                {{ csrf_field() }}

                                @php
                                $fields = [
                                [
                                [
                                'name' => 'user_id',
                                'type' => 'select',
                                'label' => PolicyMaster::attributes('user_id'),
                                'options' => PolicyMaster::optionsForUserId(),
                                'prompt' => 'Select '.PolicyMaster::attributes('user_id'),
                                'value' => $policy['user_id'],
                                ],
                                [
                                'name' => 'company_id',
                                'type' => 'select',
                                'label' => PolicyMaster::attributes('company_id'),
                                'options' => PolicyMaster::optionsForCompanyId(),
                                'prompt' => 'Select '.PolicyMaster::attributes('company_id'),
                                'value' => $policy['company_id'],
                                ],
                                ],

                                [
                                [
                                'name' => 'category_id',
                                'type' => 'select',
                                'label' => PolicyMaster::attributes('category_id'),
                                'options' => PolicyMaster::optionsForCategoryId(),
                                'prompt' => 'Select '.PolicyMaster::attributes('category_id'),
                                'value' => $policy['category_id'],
                                ],
                                [
                                'name' => 'sub_category_id',
                                'type' => 'select',
                                'label' => PolicyMaster::attributes('sub_category_id'),
                                'options' => PolicyMaster::optionsForSubCategoryId(),
                                'prompt' => 'Select '.PolicyMaster::attributes('sub_category_id'),
                                'value' => $policy['sub_category_id'],
                                ],
                                ],

                                [

                                [
                                'name' => 'plan_name',
                                'type' => 'text',
                                'label' => PolicyMaster::attributes('plan_name'),
                                'value' => $policy['plan_name'],
                                ],


                                [
                                'name' => 'policy_no',
                                'type' => 'number',
                                'label' => PolicyMaster::attributes('policy_no'),
                                'value' => $policy['policy_no'],
                                'col' => 2
                                ],
                                [
                                'name' => 'sum_assured',
                                'type' => 'number',
                                'label' => PolicyMaster::attributes('sum_assured'),
                                'value' => $policy['sum_assured'],
                                'col' => 4
                                ],

                                ],

                                [
                                [
                                'name' => 'premium_amount',
                                'type' => 'number',
                                'label' => PolicyMaster::attributes('premium_amount'),
                                'value' => $policy['premium_amount'],
                                ],
                                [
                                'name' => 'policy_term',
                                'type' => 'number',
                                'label' => PolicyMaster::attributes('policy_term'),
                                'value' => $policy['policy_term'],
                                'col' => 2
                                ],
                                [
                                'name' => 'premium_mode',
                                'type' => 'select',
                                'label' => PolicyMaster::attributes('premium_mode'),
                                'options' => PolicyMaster::optionsForPremiumMode(),
                                'prompt' => 'Select '.PolicyMaster::attributes('premium_mode'),
                                'value' => $policy['premium_mode'],
                                'col' => 4,
                                ],

                                ],
                                [
                                    [
                                        'name' => 'insurance_field_id',
                                        'type' => 'select',
                                        'label' => InsuranceFieldDetail::attributes('insurance_field_id'),
                                        'options' => InsuranceField::getInsuranceFields (),
                                        'prompt' => 'Select '.InsuranceFieldDetail::attributes('insurance_field_id'),
                                        'value' => $policy['insurance_field_id'],
                                    ],
                                ],
                                ];
                                $fields = array_merge($fields,$otherFields);
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

var $disabledResults = $("#category_id");
$disabledResults.select2();

var $disabledResults = $("#sub_category_id");
$disabledResults.select2();

var $disabledResults = $("#insurance_field_id");
$disabledResults.select2();


</script>
@endpush
